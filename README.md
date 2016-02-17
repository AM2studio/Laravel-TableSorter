# Laravel-TableSorter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via Composer

``` bash
$ composer require am2studio/laravel-table-sorter
```

## Usage

In views
```php
\AM2Studio\Laravel\TableSorter\TableSorter::sort(
    array $headings, 
    \Illuminate\Pagination\LengthAwarePaginator $paginator,
    array $config
);
```

variable $headings contains name and title for table columns, example for users
```php
[
  ['name' => 'first_name', 'title' => trans('ui.user.first_name')],
  ['name' => 'last_name',  'title' => trans('ui.user.last_name')],
  ['name' => 'gender',     'title' => trans('ui.user.gender')],
]
```

variable $config contains name and title for table columns, example for users
```php
[
    'sort_by' => 'name', 'sort_type' => 'ASC',
    'template' => '<th><a href="%s">%s</a></th>'
]
```

Code in view :
```php
{{ \AM2Studio\Laravel\TableSorter\TableSorter::sort(
    [
      ['name' => 'first_name', 'title' => trans('ui.user.first_name')],
      ['name' => 'last_name',  'title' => trans('ui.user.last_name')],
      ['name' => 'gender',     'title' => trans('ui.user.gender')],
    ],
    $users,
    [
        'sort_by' => 'name', 'sort_type' => 'ASC',
        'template' => '<th><a href="%s">%s</a></th>'
    ])
}}
```

Controller code:
```php
public function index()
{
    $users = (new User)->paginate(10);
    return $this->view('index', compact('users'));
}
```

It is recommended that you use ```Relation::morphTo([])``` because that way if you change the namespace of your model the records in DB won't break.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Credits

- [Filip Horvat][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
