<?php

namespace EMedia\Lotus\Elements\Dropzone;

use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class Uploader extends BaseElement
{
	protected $tag = 'form';

    protected $view = 'list';

    protected $options = [];

    public function withOptions(array $options)
    {
        $this->options = array_merge([
            'id' => uniqid(),
            'url' => '/manage/files',
        ], $options);

		if (isset($options['view'])) {
			$this->view = $options['view'];
		}

        return $this;
    }

	public function render()
	{
        $dropzoneOptions = [];
        if (!empty($this->options['dropzoneOptions'])) {
            foreach ($this->options['dropzoneOptions'] as $key => $value) {
                if ($value === true) {
                    $value = 'true';
                }
                if ($value === false) {
                    $value = 'false';
                }
                $dropzoneOptions[] = $key . ': ' . $value;
            }
        }

        $html = '<form class="dropzone ' . $this->view . '" action="' . $this->options['url'] . '" method="post" id="dropzone-u' . $this->escape($this->options['id']) . '">' .
            csrf_field() .
            '<input type="hidden" name="key" value="other">' .
            '<input type="hidden" name="custom_key" value="">' .
            '<input type="hidden" name="allow_public_access" value="0">' .
            '<input type="file" name="file" value="">' .
        '</form>';

        $js = '<script type="text/javascript" src="' . asset('bower_components/dropzone/dist/min/dropzone.min.js') . '"></script>' . "\n" .
            '<script type="text/javascript">' . "\n" .
            'Dropzone.options.dropzoneU' . $this->escape($this->options['id']) . ' = {' . "\n";
		$js .= "init: function() {\n";
		if (isset($this->options['attachmentsFormId'])) {
			$js .= "	this.on('success', function(file, res) {\n";
			$js .= "	var input = document.createElement('input');\n";
			$js .= "	input.setAttribute('type', 'hidden');\n";
			$js .= "	input.setAttribute('name', 'attachments[]');\n";
			$js .= "	input.setAttribute('id', res.payload.uuid);\n";
			$js .= "	input.setAttribute('value', res.payload.uuid);\n";
			$js .= "	document.getElementById('" . $this->options['attachmentsFormId'] . "').appendChild(input);\n";
		 	$js .= "});\n";

			$js .= "this.on('removedfile', function(file) {\n";
			$js .= "	console.log(file); document.getElementById(file.upload.uuid).remove();\n";
		 	$js .= "});\n";
		}
		$js .= '},';
        if (!empty($dropzoneOptions)) {
            $js .= "\n" . implode(",\n", $dropzoneOptions) . "\n";
        }

        $js .= '};' . "\n";
		$js .= '</script>';

        $output = $html . "\n\n" . $js;

		return new HtmlString($output);
	}

}
