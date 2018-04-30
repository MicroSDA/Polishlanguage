/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	 config.filebrowserUploadUrl = '/file-upload/upload/';
	 config.filebrowserBrowseUrl = '/file-upload/get/';
	 config.extraPlugins = 'filebrowser';
	 config.extraPlugins = 'uploadfile';
	// Define changes to default configuration here. For example:
	  config.language = 'ru';
	// config.uiColor = '#AADC6E';
};
