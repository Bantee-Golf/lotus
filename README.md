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

#### Main Page Headline
```
{{ lotus()->pageHeadline('My New Page') }}
```

#### Breadcrumbs
```
{{ lotus()->breadcrumbs([
    ['Dashboard', route('dashboard')],
    ['Google', 'http://www.google.com'],
    ['Microsoft', 'http://www.microsoft.com'],
    ['Tesla', null, true]
]) }}
```
The last parameter should be `true` if it should be `active`

#### Empty State Panel
```
{{-- Default --}}
{{ lotus()->emptyStatePanel() }}

{{-- Panel with Custom Messages --}}
{{ lotus()->emptyStatePanel('Welcome to Oxygen', "Let's Build Something New!") }}
```

#### Explain Panel (Generic HTML)
```
{{ lotus()->explainPanel('<div>Show my thing here</div>') }}
```

#### Table Header

Render a table `<thead>` section

```
{{ lotus()->tableHeader('ID', 'Name', 'Age', 'Actions') }}

{{-- Pass a CSS Class --}}
{{ lotus()->tableHeader('ID', 'Name', 'Age', 'Actions|text-right') }}
```

#### Page Numbers (Pagination)

Show the page number links for a page. Accepts a `LengthAwarePaginator` object.

```
{{ lotus()->pageNumbers(Users::paginate()) }}
```

#### Search Field

Get a query string and post back to the same page with a `q` in the URL
```
{{ lotus()->searchField() }}
```

#### Google Places Autocomplete & Map

Create a Google Places Autocomplete field for address lookup. This element will also breakdown an address to components such as address, city, postcode, state, country, country code.

**Step 1 - Frontend Setup**

Reference the required JS file from in main project. In this example, we're using Laravel Mix.
```
mix.js('vendor/emedia/lotus/src/resources/js/GooglePlacesAutoComplete.js', 'public_html/js/dist')
   .version();	
```
On your HTML file, refer to the above script and the Google Maps library. For the below example to work, set `GOOGLE_MAPS_API_KEY` in your `.env` file.

```
@push('scripts')
	<script src="{{ mix('js/dist/GooglePlacesAutoComplete.js') }}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initAutoComplete" async defer></script>
@endpush
```

**Step 2 - Show the Field**

Show the field with default settings.
```
{{ lotus()->locationField() }}
```

**Step 3 - (Optional) Multiple Maps and Customising**

If you need to include multiple autocomplete fields on the page, you need to customise the output. Use the `locationConfig()` function for this.

Example: Using Multiple Maps on the Same Page
```
<!-- Layout with default settings -->
{{ lotus()->locationField() }}

<!-- Customise for multiple autocomplete fields. All fields are optional. -->
{{ lotus()->locationField(lotus()->locationConfig()
                ->setAddress('123, Straight Road')  // Display address on the main input
                ->showAddressComponents()           // Hidden by default. Call this for debugging.
                ->setInputFieldPrefix('places_2_')     // Unique prefix for each location field. Eg: `destination_`
                ->setSearchBoxElementId('js-places-2') // Unique Autocomplete Field ID
                ->setMapElementId('map2')              // Unique Map ID  
                ->setFieldLabel('Return Address')      // Optional main input label
                
                // Customise which results are shown in the Autocomplete
                // https://developers.google.com/maps/documentation/javascript/reference/places-widget#AutocompleteOptions   
                ->setAutoCompleteOptions([
                    'types' => ['establishment'],
                    'componentRestrictions' => [
                        'country' => 'lk',
                    ]
                ])
                
                ->hideMap()                         // Hide Google Map
                ) }}
```

The above will work for most situations. If you need to further customise the AutoComplete options, modify the JavaScript section as below.

```
@push('scripts')
    <script>
	    // https://developers.google.com/maps/documentation/javascript/reference/places-widget#AutocompleteOptions
	    window._location = window._location || {};
	    window._location.autoCompleteOptions = [
		    null,   // skip the first map, so that it uses defaults
		    
		    // AutoComplete options for the second map   
		    {
			    types: ['establishment'],
			    componentRestrictions: {'country': 'nz'}
		    }
	    ];
	    
	   // enable debug mode - can be used during development to see places results in Console 
       window._location.debug = true;
    </script>
    <script src="{{ mix('js/dist/GooglePlacesAutoComplete.js') }}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initAutoComplete" async defer></script>
@endpush
```

**Step 4 - (Optional) Get Additional Data**

The following fields are also availalble to auto-fill. 

```
name (Business or Venue name)
phone
phone_iso
website
```

To get data for these fields add elements with the class `js-autocomplete` and the correct name to the page.

Example:

```
<input class="js-autocomplete" name="phone" type="text" value="">

If you have multiple maps, use the field prefix
<input class="js-autocomplete" name="_map2_phone" type="text" value="">
```

### Creating Custom Elements

Lotus is a wrapper around [Laravel HTML](https://github.com/spatie/laravel-html).

So you can do calls such as,
```
{{ lotus()->span()->text('Hello world!')->class('fa fa-eye') }}
```

### Want to Add New Elements?

Create a new branch and submit a pull request.
