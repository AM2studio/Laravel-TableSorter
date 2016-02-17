# Laravel-TableSorter

Package contains helper function for creating sortable colums in table

## Install

Via Composer

``` bash
$ composer require am2studio/laravel-table-sorter
```

## Usage


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

variable $headings contains name and title for table columns, example for users
```php
[
  ['name' => 'first_name', 'title' => trans('ui.user.first_name')],
  ['name' => 'last_name',  'title' => trans('ui.user.last_name')],
  ['name' => 'gender',     'title' => trans('ui.user.gender')],
]
```

variable $config contains default sort_by/sort_type and template
```php
[
    'sort_by' => 'name', 'sort_type' => 'ASC',
    'template' => '<th><a href="%s">%s</a></th>'
]
```

Controller code:
```php
public function index()
{
    $users = (new User)->paginate(10);
    return $this->view('index', compact('users'));
}
```

Full view table :
```php
<table>
	<thead>
		<tr>
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
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
		<tr>

			<td>{{ $user->first_name }}</td>
			<td>{{ $user->last_name }}</td>
			<td>{{ $user->gender }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div>{!! $users !!}</div>
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
