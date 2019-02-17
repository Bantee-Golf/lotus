<?php


namespace EMedia\Lotus\Elements\Page\Location;


use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class LocationField extends BaseElement
{

	/** @var LocationConfig $inputFieldPrefix */
	protected $locationConfig = null;

	public function withConfig(LocationConfig $locationConfig)
	{
		$this->locationConfig = $locationConfig;

		return $this;
	}

	/**
	 *
	 * Render the element
	 *
	 * @return \Illuminate\Contracts\Support\Htmlable|HtmlString
	 */
	public function render()
	{
		if (!$this->locationConfig) throw new \InvalidArgumentException('LocationConfig must be set before rendering a location field.');

		$inputFieldPrefix = $this->escape($this->locationConfig->inputFieldPrefix);
		$fieldLabel = $this->escape($this->locationConfig->fieldLabel);
		$autoCompleteOptions = $this->locationConfig->autoCompleteOptions;
		$mapElementId = $this->escape($this->locationConfig->mapElementId);
		$searchBoxElementId = $this->escape($this->locationConfig->searchBoxElementId);

		$htmlString = '
			<div class="form-group-location location-field-address row">';

		if ($fieldLabel) {
			$htmlString .= '<label for="" class="col-sm-2 control-label">' . $fieldLabel . '</label>';
		}

		$htmlString .= '<div class="col-sm-12 mb-2">
					<input type="text" id="' . $searchBoxElementId . '" class="form-control js-autocomplete" name="address" autocomplete="false" value="' . $this->escape($this->locationConfig->address) . '" >
				</div>
			</div>';

        if ($this->locationConfig->showAddressComponents) {
        	$htmlString .= '
				<div class="form-group-location location-field-address-components row">
					<div class="col-sm-12">
						<div class="row mb-2">
							<div class="col-6">
								<input type="text" name="' . $inputFieldPrefix . 'formatted_address" class="form-control js-autocomplete js-tooltip" data-title="Address" readonly placeholder="(Address)">
							</div>
							<div class="col-3">
								<input type="text" name="' . $inputFieldPrefix . 'latitude" class="form-control js-autocomplete js-tooltip" data-title="Latitude" readonly placeholder="(Latitude)">
							</div>
							<div class="col-3">
								<input type="text" name="' . $inputFieldPrefix . 'longitude" class="form-control js-autocomplete js-tooltip" data-title="Longitude" readonly placeholder="(Longitude)">
							</div>
						</div>
						<div class="row mb-2">
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'street" class="form-control js-autocomplete js-tooltip" data-title="Street" readonly placeholder="(Street)">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'street_2" class="form-control js-autocomplete js-tooltip" data-title="Street 2" readonly placeholder="(Street 2)">
							</div>
						</div>
						<div class="row mb-2">
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'city" class="form-control js-autocomplete js-tooltip" data-title="City" readonly placeholder="(City)">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'state" class="form-control js-autocomplete js-tooltip" data-title="State" readonly placeholder="(State)">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'state_iso_code" class="form-control js-autocomplete js-tooltip" data-title="State Code" readonly placeholder="(State Code)">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'zip" class="form-control js-autocomplete js-tooltip" data-title="Post Code" readonly placeholder="(Post Code)">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'country" class="form-control js-autocomplete js-tooltip" data-title="Country" readonly placeholder="(Country)">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'country_iso_code" class="form-control js-autocomplete js-tooltip" data-title="Country Code" readonly placeholder="(Country Code)">
							</div>
						</div>
					</div>
				</div>';
		}

		if ($this->locationConfig->showMap) {
			$htmlString .= '
			<div class="form-group-location location-field-map row">
				<div class="col-sm-12">
					<div id="' . $mapElementId . '"></div>
				</div>
			</div>';
		}

		$autoCompleteOptionString = ($autoCompleteOptions) ? json_encode($autoCompleteOptions) : 'null';

		$htmlString .= '<script>
			window._location = window._location || {};
			if (!window._location.places) window._location.places = [];
			window._location.places.push({
				mapElementId: "' . $mapElementId . '",
				searchBoxElementId: "' . $searchBoxElementId . '",
				inputFieldPrefix: "' . $inputFieldPrefix .'",
				autoCompleteOptions: ' . $autoCompleteOptionString . ',
			});
		</script>';

		return new HtmlString($htmlString);
	}

}
