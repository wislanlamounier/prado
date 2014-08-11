/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */


CKEDITOR.editorConfig = function( config ){
    config.filebrowserBrowseUrl = 'js/ckfinder/ckfinder.html',
    config.filebrowserImageBrowseUrl = 'js/ckfinder/ckfinder.html?type=Images',
    config.filebrowserFlashBrowseUrl = 'js/ckfinder/ckfinder.html?type=Flash',
    config.filebrowserUploadUrl = 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Files',
    config.filebrowserImageUploadUrl = 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Images',
    config.filebrowserFlashUploadUrl = 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Flash'
};