# Kirby Facets

Composable query filters and faceted-search UI for [Kirby CMS](https://getkirby.com) collections — filter a collection by request parameters without reinventing `filterBy()`, and render the matching form controls from the same declaration.

## Requirements

Kirby CMS (`>=5.5`)  
PHP (`>= 8.2`)

## Installation

### Composer

```sh
composer require hksagentur/kirby-facets
```

### Download

Download the project archive and copy the files to the plugin directory of your kirby installation. By default this directory is located at `/site/plugins`.

## Usage

### A plain `Filter`/`Filters` pipeline

Every filter reads its value lazily from the request. The first argument is always the query parameter name. `Filter::in()` filters by membership, delegating straight to Kirby's own `filterBy($field, 'in', $values)`:

```php
<?php

use Hks\Facets\Http\Filter;
use Hks\Facets\Http\Filters;

$filters = Filters::for($page->children()->listed())
    ->add(Filter::in('season'));

$concerts = $filters->apply();
```

A small set of named comparison filters cover the common single-value `filterBy()` operators. `Filter::equals()` (`==`) is the natural pairing for a `Facet::radio()`/select-style control. `Filter::after()`/`Filter::before()` (`date >`/`date <`) compare dates chronologically rather than as raw strings:

```php
Filter::equals('category');
Filter::after('published'); // ?published=2024-03-01
```

`Filter::atLeast()`/`Filter::atMost()` (`>=`/`<=`) compare numbers the same way:

```php
Filter::atLeast('floorSize'); // ?floorSize=80 → floorSize >= 80
Filter::atMost('price');      // ?price=500000 → price <= 500000
```

> [!NOTE]
> `atLeast()`/`atMost()` compare correctly even when the underlying field is stored as a raw `Kirby\Content\Field` — no manual casting needed.

`Filter::search()` delegates to Kirby's own free-text search across the given fields — it needs a `Kirby\Cms\Collection` (`Pages`/`Files`/`Users`/`Structure`), not just any collection:

```php
Filter::search(['title', 'text']); // reads ?q=... by default, override via the 2nd argument
```

For relational filters, `Filter::belongsTo()` resolves the request values against a named site collection first, then checks whether the resolved items intersect the attribute — useful when the request sends foreign keys (e.g. a related page's ID) rather than values you can compare directly:

```php
Filters::for($concerts)
    ->add(Filter::in('season'))
    ->add(Filter::belongsTo(name: 'series', collection: 'concert-series'));
```

If the request values are already directly comparable and there's nothing to resolve, `Filter::hasAny()` does the same attribute-side check without the collection lookup.

For anything none of the above covers, `Filter::callback()` is the escape hatch — it receives the collection and the filter's own resolved request value, and returns the (usually filtered) collection itself:

```php
Filter::callback('limit', fn (Collection $collection, mixed $value) => $collection->limit((int) $value));
```

### Composing filters

`Filter::not()` inverts another filter's matches against the same input collection:

```php
Filter::not(Filter::equals('category')); // everything that does NOT match
```

Like every other filter, `Filter::not()` is a no-op when its wrapped filter has no active value — the request parameter it reads is the wrapped filter's own (`->from()` on the `Not` instance renames the wrapped filter too, so both stay in sync).

Prefer a plain array and this plugin's own `pipe()` collection method instead, if you don't need the name-indexed lookup `Filters` provides:

```php
<?= $page->children()->listed()->pipe([
    Filter::in('season'),
    Filter::belongsTo(name: 'series', collection: 'concert-series'),
]) ?>
```

### The `Filterable` interface

Declare a page model's default filters once, then pull them into a controller — a subset via `only`, or all of them:

```php
<?php

use Hks\Facets\Cms\Filterable;
use Hks\Facets\Http\Filter;

class ConcertPage extends Page implements Filterable
{
    public static function filters(): array
    {
        return [
            Filter::in('season'),
            Filter::belongsTo(name: 'series', collection: 'concert-series'),
        ];
    }
}
```

```php
<?php

$filters = Filters::for($concerts)->use(ConcertPage::filters(), ['season']);
$concerts = $filters->apply();
```

### Overriding a filter's parameter name

On an `Attribute`-based filter (`equals`, `after`, `in`, …), an optional second argument names the collection attribute to filter by, if it should differ from the query parameter. Both default to the same value:

```php
Filter::in('season');                                // reads ?season=..., filters the season attribute
Filter::in(name: 'spielzeit', attribute: 'season');   // reads ?spielzeit=..., filters the season attribute
```

For two controllers that need the *same already-constructed* filter (e.g. one declared on a `Filterable` model) exposed under a different query parameter, `->from()` renames just the query parameter, independently of the attribute:

```php
Filter::in('season')->from('spielzeit');
// ->attribute() still returns 'season'; only ->name() becomes 'spielzeit'
```

### Declaring facets

A `Facet` reads its own value from the request by query parameter name, independently of any `Filter` — if a facet should narrow the same collection a `Filter` filters, give both the same name. `Facet` type names match Kirby Panel's own field type names (`checkboxes`, `radio`, `select`, `date`, `toggle`) — `toggle` pairs naturally with `Filter::equals()` for a plain boolean field, no dedicated `Toggle` filter needed:

```php
<?php

use Hks\Facets\Form\Facet;
use Hks\Facets\Form\Facets;

$facets = new Facets([
    Facet::checkboxes(label: 'Season', name: 'season', options: fn () => Seasons::options()),
    Facet::date(label: 'Date', name: 'date'),
    Facet::toggle(label: 'Musiktheater', name: 'musiktheater'),
]);
```

`checkboxes`/`radio` accept the options list as an `array` of `['value' => ..., 'label' => ..., 'icon' => ...]` pairs (`icon` optional), an already-built `Options` instance, or a `Closure` returning either — evaluated lazily and at most once per facet, however many times its snippet reads `options()`. Each pair becomes an `Option` (`value()`, `label()`, `icon()`, `hasIcon()`, `isChecked()`).

Building that pairs list from an existing Kirby collection is common enough to have its own collection method, available on every `Kirby\Cms\Collection`: `toFacetOptions(Closure|string|null $value = null, ?string $label = null, Closure|string|null $icon = null): Options`. Defaults to `id`/`title` (matching `Pages`), `icon` defaults to none; pass a field/method name or a per-item `Closure` for any of the three:

```php
Facet::radio(
    label: 'Season',
    name: 'season',
    options: fn () => $kirby->collection('seasons')->toFacetOptions(),
);

Facet::radio(
    label: 'Category',
    name: 'category',
    options: fn () => $categories->toFacetOptions(label: 'name'), // Structure: no title(), has 'id'/'name'
);

Facet::radio(
    label: 'House type',
    name: 'house_type',
    options: fn () => $page->houseTypes()->toFacetOptions(icon: 'icon'), // reads the page's own `icon` field
);
```

### Preselecting a facet's value

`->default()` gives a facet a value to fall back to while its query parameter is missing — e.g. a landing page that is itself one option of the facet and should show it preselected:

```php
Facet::radio(
    label: 'House type',
    name: 'house_type',
    options: fn () => $page->houseTypes()->toFacetOptions(),
)->default($houseType->id());
```

A default only prefills the control: the facet doesn't count as active, so it gets no applied-filter chip, clear link or reset link of its own. `value()` returns the default while the parameter is missing; `input()` always returns the raw request value, ignoring it — the one to check before acting on a real selection:

```php
if ($facet->isActive()) {
    // the visitor picked $facet->input(), not just the default
}
```

`isEmpty()` follows `isActive()`, so a facet holding only its default counts as empty. The conversion helpers don't: `split()`, `toPage()`, `toPages()`, `toInt()`, `toFloat()`, `toBool()`, `toTimestamp()` and `toDate()` all read `value()` and resolve the default like a real selection. Go through `$facets->active()` when only a submitted value should count:

```php
$facet->toPage();                                // the visitor's pick, or the default
$facets->active()->get('house_type')?->toPage(); // the visitor's pick only
```

`toPage()` and `toPages()` resolve each value as a page ID or UUID. Pass a scope collection and a bare slug resolves too, since slugs are only unique among siblings — handy when the facet's options use `toFacetOptions(value: 'slug')` for shorter URLs:

```php
$facets->active()->get('house_type')?->toPage($page->children()->listed());
```

A default never filters anything: it only affects the facet, not a `Filter` with the same name. Narrow the collection itself if the page stands for one of the options.

### Rendering with `Facet`/`Facets`

`echo $facets` (or `$facets->render()`/`$facets->toHtml($attributes)`) renders the whole `<form>` — every facet's own markup plus a submit button — via the overridable `facets/form` snippet. Loop over `$facets` yourself instead if you don't want that wrapper:

```php
<?php foreach ($facets as $facet): ?>
  <?= $facet ?>
<?php endforeach ?>
```

Inside a facet's snippet, `$facet->options()` yields its `Option`s:

```php
<?php foreach ($facet->options() as $option): ?>
  <label>
    <input type="checkbox" name="season[]" value="<?= esc($option->value()) ?>" <?= $option->isChecked() ? 'checked' : '' ?>>
    <?= esc($option->label()) ?>
  </label>
<?php endforeach ?>
```

An `Option::icon()` value is only ever a string your project gave it — the plugin has no opinion on what it means (an SVG sprite symbol, an icon font class, whatever). `checkboxes`/`radio` render it through the overridable `facets/icon` snippet, which ships an inert default (a `<span data-icon="…">`, nothing visually happens) — see [Overriding the default markup](#overriding-the-default-markup) to hook it into your project's actual icon system. Since the plugin doesn't know your icon set, make sure whatever CMS field feeds `icon` only ever holds values that are known to exist (e.g. an options/select field backed by your real icon inventory) rather than free text — otherwise you're relying on your own icon snippet to fail gracefully on typos.

`checkboxes`/`radio` can also hide their options' visible labels via `->hideLabels()` (or `->showLabels()`/`->labels(bool)`), mirroring Kirby's own `toggles` `labels: false` — useful for an icon-driven option group where the label would otherwise be redundant next to the icon:

```php
Facet::radio(
    label: 'House type',
    name: 'house_type',
    options: fn () => $page->houseTypes()->toFacetOptions(icon: 'icon'),
)->hideLabels();
```

The bundled snippets keep each option's label in the DOM either way, inside its usual `radio__label`/`checkbox__label` span — hiding it visually is done by adding a `visually-hidden` class to that span whenever `shouldHideLabels()` is `true`, so it stays available to screen readers. `Select` has no equivalent: a native `<option>` can't hide its text and show an icon instead.

`Facets` indexes by `Facet::name()` regardless of how items were added. `active()`/`featured()`/`advanced()` filter down to the facets currently applied, flagged via `->featured()`, or not — the bundled `facets/form` snippet uses these to decide what to show right away versus tucked behind a disclosure; see [Overriding the default markup](#overriding-the-default-markup) to change that behavior.

`Facet::links()` returns every currently active value as a `Link` — its own label plus the URL with just that value removed, the building block for a removable filter chip. `Facets::links()` collects every active facet's `Link`s into a `Links` list and — like `Facet`/`Facets` — knows how to render itself via an overridable snippet:

```php
echo $facets->links(); // <ul> of removable chips, via the facets/links snippet
```

### Showing the applied filters

The bundled `facets/applied-filters` snippet wraps those links into the section that usually sits above the results: the chips, a link removing all of them at once, and the number of matching items. It renders nothing while no facet is active, so it can be included unconditionally:

```php
<?php snippet('facets/applied-filters', [
    'facets' => $facets,
    'total' => $items->pagination()?->total(),
]) ?>
```

The total is never derived: facets don't know the collection they filter, so hand it over from wherever you applied your `Filters`. The snippet isn't part of `$facets->render()`: place it wherever the results are.

### Overriding a facet's value formatting

`->formatUsing()` receives the raw active value and the facet's own best-effort label, so you can tweak it instead of recomputing it from scratch:

```php
Facet::checkboxes(label: 'Season', name: 'season', options: fn () => Options::seasons())
    ->formatUsing(fn (string $value, string $label) => "Season {$label}");
```

`formatUsing()` takes any callable. For the common cases, `Format` builds one without a closure — the prefix and suffix are joined with a space, a template gets `{{ value }}` and `{{ label }}`:

```php
use Hks\Facets\Form\Format;

Facet::select(label: 'Energy class', name: 'energy_class', options: fn () => Options::energyClasses())
    ->formatUsing(Format::prefix('Energy class')); // "Energy class A+"

Facet::select(label: 'Floor size', name: 'floor_size', options: fn () => Options::floorSizes())
    ->formatUsing(Format::suffix('m²')); // "120 m²"

Facet::select(label: 'Floor size', name: 'floor_size', options: fn () => Options::floorSizes())
    ->formatUsing(new Format(prefix: 'from', suffix: 'm²')); // "from 120 m²"

Facet::select(label: 'Rooms', name: 'rooms', options: fn () => Options::rooms())
    ->formatUsing(Format::template('{{ label }}+ rooms')); // "3+ rooms"
```

Cast to a string, a `Format` shows the template it fills — handy for debugging or for handing the rule on: `(string) Format::prefix('Energy class')` is `'Energy class {{ label }}'`.

### Writing your own filter

Every bundled filter except `Callback` fits a "check whether the request value is set, then apply it" shape:

```php
public function __invoke(Collection $collection): Collection
{
    return $this->isEmpty() ? $collection : $this->apply($collection);
}
```

`isEmpty()` and `apply()` are both public, so a caller (or a composing filter, like `Not`) can call either directly.

A filter that targets a single named attribute on the collection's items extends `Hks\Facets\Http\Filter\Attribute` instead of `Filter` directly — it already declares `__construct(string $name, ?string $attribute = null)`, so most filters need no constructor of their own, just an `apply()` override reading `attribute()`/`value()`:

```php
<?php

namespace App\Filters;

use Hks\Facets\Http\Filter\Attribute;
use Kirby\Cms\Collection;

class GreaterThan extends Attribute
{
    public function apply(Collection $collection): Collection
    {
        return $collection->filterBy($this->attribute(), '>', $this->value());
    }
}
```

A filter that needs extra constructor arguments (like `BelongsTo`'s `$collection`, or `Search`'s `$fields`) still declares its own constructor, calling `parent::__construct($name, $attribute)`. A filter with no single-attribute concept at all — `Search` (searches several fields), `Callback` (a closure decides everything) — extends the plain `Filter` base instead and has no `attribute()`.

`value()` trims string values, so `'   '` counts as unset. Override `isEmpty()` if "empty" means something else for your filter — `In`/`HasAny`/`BelongsTo` treat an empty array as unset, since a request can submit `name[]` with nothing selected. For a filter that doesn't fit the "check emptiness, then apply" shape at all, override `__invoke()` directly instead.

### Overriding the default markup

`Facet::render()` resolves `facets/checkboxes`, `facets/radio`, `facets/select`, `facets/date`, or `facets/toggle`; `Facets::render()`/`Links::render()` resolve `facets/form`/`facets/links` the same way. Kirby resolves a snippet against `site/snippets/` before falling back to a plugin-registered snippet of the same name, so replacing the plugin's markup with your own design system needs no plugin option — just add the same-named file to your own project:

```
site/snippets/facets/checkboxes.php
site/snippets/facets/radio.php
site/snippets/facets/select.php
site/snippets/facets/date.php
site/snippets/facets/toggle.php
site/snippets/facets/form.php
site/snippets/facets/applied-filters.php
site/snippets/facets/links.php
site/snippets/facets/icon.php
```

Overriding one of these changes it for every facet of that type. To change just one specific facet — a `radio` facet named `house_type` rendered as icons with no visible label, say, while every other `radio` facet keeps the default markup — add a snippet named `facets/{type}--{name}` instead; it wins over the type-wide one, which stays the fallback for everything else:

```
site/snippets/facets/radio--house-type.php
```

The name is slugified first (via Kirby's own `Str::slug()`) — `house_type` becomes `house-type`, and anything not already a clean identifier gets normalized the same way.

Every bundled snippet does ship its own class names (`radio-group`, `checkbox__input`, `toggle__label`, `dialog__close`, `badge`, …), but no CSS at all — nothing is styled until you write some, targeting those classes or the bare elements (`fieldset`, `legend`, `input[type=checkbox]`, …) directly. `toHtml(array $attributes = [])` (on `Facet`, `Facets`, and `Links`) merges extra HTML attributes onto the root element without needing a full override:

```php
$facets->toHtml(['class' => 'search-form']);
```

> [!NOTE]
> Inside an overriding snippet, that merged set arrives as `$attr`, not `$attributes`.

A full snippet override is only needed for restructuring the markup itself. For layout changes that just rearrange *which* facets go where, skip `Facets::render()` and compose the pieces yourself:

```php
<?php foreach ($facets->featured() as $facet): ?>
  <details>
    <summary><?= esc($facet->label()) ?></summary>
    <?= $facet ?>
  </details>
<?php endforeach ?>
```

## License

ISC License. Please see [License File](LICENSE.txt) for more information.
