Yii2 Lepture Markdown Editor widget
---

Yii2 widget for Lepture Markdown Editor (https://github.com/lepture/editor) - A markdown editor you really want

## Demo

on [http://lab.lepture.com/editor/](http://lab.lepture.com/editor/)

## Installation via Composer
add to `require` section of your `composer.json`
`"ijackua/yii2-lepture-markdown-editor-widget"`
and run composer update

## Usage example

### Active widget

```php
use ijackua\lepture\Markdowneditor;

Markdowneditor::widget(
			[
				'model' => $model,
				'attribute' => 'full_text',
			])
```

### Simple widget

```php
use ijackua\lepture\Markdowneditor;

Markdowneditor::widget(
			[
				'name' => 'editor',
				'value' => '# Hello world'
			])
```

## Editor options

see on [official site](https://github.com/lepture/editor)

```php
use ijackua\lepture\Markdowneditor;

Markdowneditor::widget(
			[
				'model' => $model,
				'attribute' => 'full_text',
				'leptureOptions' => [
					'toolbar' => false
				]
			])
```

## Marked options (markdown parser used by Lepture Editor)
see on [official Marked site](https://github.com/chjj/marked)

```php
use ijackua\lepture\Markdowneditor;

Markdowneditor::widget(
			[
				'model' => $model,
				'attribute' => 'full_text',
				'markedOptions' => [
					'tables' => false
				]
			])
```