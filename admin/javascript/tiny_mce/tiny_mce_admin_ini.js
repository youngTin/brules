tinyMCE.init({
	mode : "textareas",
	//mode : "exact",
	elements : "comments,content",

	theme : "advanced",
	//plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	plugins : "inlinepopups",

	theme_advanced_buttons1 : "bold,italic,underline,fontsizeselect,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "none",
	theme_advanced_path_location : "bottom",
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : false,
	content_css : "/styles/tiny_mce.css",
	entity_encoding : "raw",
	language : "zh",
	relative_urls : false,
	//valid_elements : "br,a[href|target],-p[align|style],img[src|cdmcsid|alt|width|height|border|align|class],-span[style],-strong/b[style],-div[align],+table[border|cellspacing|cellpadding|width|height|class|align=center|summary|style|dir|id|lang|bgcolor|background|bordercolor],tr[id|lang|dir|class|rowspan|width|height|align|valign|style|bgcolor|background|bordercolor],tbody[id|class],thead[id|class],tfoot[id|class],td[id|lang|dir|class|colspan|rowspan|width|height|align|valign|style|bgcolor|background|bordercolor|scope],th[id|lang|dir|class|colspan|rowspan|width|height|align|valign|style|scope]"

	extended_valid_elements : "a[name|href|target|title|onclick],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
	
});