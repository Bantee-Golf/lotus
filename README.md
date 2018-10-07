# Lotus - Build HTML Elements

Build common HTML elements in 1 line of code.

### Installation Instructions

Add the repository to `composer.json`
```
"repositories": [
	{
	    "type":"vcs",
	    "url":"git@bitbucket.org:elegantmedia/lotus.git"
	}
]
```

```
composer require emedia/lotus
```

### Available Elements

Use these function calls directly within Blade templates.

##### Main Page Headline
```
{{ lotus()->pageHeadline('My New Page') }}
```

##### Breadcrumbs
```
{{ lotus()->breadcrumbs([
    ['Dashboard', route('dashboard')],
    ['Google', 'http://www.google.com'],
    ['Microsoft', 'http://www.microsoft.com'],
    ['Tesla', null, true]
]) }}
```
The last parameter should be `true` if it should be `active`

##### Empty State Panel
```
{{-- Default --}}
{{ lotus()->emptyStatePanel() }}

{{-- Panel with Custom Messages --}}
{{ lotus()->emptyStatePanel('Welcome to Oxygen', "Let's Build Something New!") }}
```

##### Explain Panel (Generic HTML)
```
{{ lotus()->explainPanel('<div>Show my thing here</div>') }}
```

##### Table Header

Render a table `<thead>` section

```
{{ lotus()->tableHeader('ID', 'Name', 'Age', 'Actions') }}
```

##### Page Numbers (Pagination)

Show the page number links for a page. Accepts a `LengthAwarePaginator` object.

```
{{ lotus()->pageNumbers(Users::paginate()) }}
```

### Creating Custom Elements

Lotus is a wrapper around [Laravel HTML](https://github.com/spatie/laravel-html).

So you can do calls such as,
```
{{ lotus()->span()->text('Hello world!')->class('fa fa-eye') }}
```

### Want to Add New Elements?

Create a new branch and submit a pull request.
