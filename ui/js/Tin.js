 var Tin = {
    basePath:'/ui/js',
    IS_IE6: navigator.userAgent.indexOf('MSIE 6') >= 0,
    include:function(src)
    {
        document.write('<script src="'+src+'"></script>');
    },
    link: function(rel, href, doc)
    {
        doc = doc || document;

        // Workaround for Operation Aborted in IE6 if base tag is used in head
        if (Tin.IS_IE6)
        {
            doc.write('<link rel="'+rel+'" href="'+href+'" charset="ISO-8859-1" type="text/css"/>');
        }
        else
        {    
            var link = doc.createElement('link');
            
            link.setAttribute('rel', rel);
            link.setAttribute('href', href);
            link.setAttribute('charset', 'ISO-8859-1');
            link.setAttribute('type', 'text/css');
            
            var head = doc.getElementsByTagName('head')[0];
               head.appendChild(link);
        }
    },
    artSkin:'default',
    rwidth:'auto'
};
Tin.include(Tin.basePath+'/artDialog/artDialog.min.js');
Tin.include(Tin.basePath+'/Tin.common.js');

