# Lotus

Generate HTML components.

```
		$html = html();



//		$tag = $html->div()->addClass('title-container')->addChild(
//			$html->div()->addClass('page-title')->addChild(
//				$html->element('h1')->text($this->title)
//			)
//		);

		$tag = $html->div(
'<div class="title-container">
			<div class="page-title">
				<h1>' . $this->escape($this->title) . '</h1>
			</div>
		</div>');

		$html = '<div class="title-container">
			<div class="page-title">
				<h1>' . $this->escape($this->title) . '</h1>
			</div>
		</div>';

		return new HtmlString($html);
```