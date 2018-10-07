<?php

if (! function_exists('lotus'))
{

	function lotus()
	{
		return app(\EMedia\Lotus\Base\LotusHtml::class);
	}

}
