var WEBSITE_URL = '{domain}';
var PT = {
    createForm: function (dom) {
        this.loadjscssfile(WEBSITE_URL + '/Theme/assets/css/amazeui.min.css', 'css')
        this.loadjscssfile(WEBSITE_URL + '/Theme/assets/css/ui-dialog.css', 'css')
        this.loadjscssfile(WEBSITE_URL + '/Theme/assets/css/webuploader.css', 'css')

        this.loadjscssfile(WEBSITE_URL + '/Theme/assets/js/amazeui.min.js', 'js')
        this.loadjscssfile(WEBSITE_URL + '/Theme/assets/js/webuploader.js', 'js')
        this.loadjscssfile(WEBSITE_URL + '/Theme/assets/js/AMUIwebuploader.js', 'js')
        this.loadjscssfile(WEBSITE_URL + '/Theme/assets/js/dialog-min.js', 'js')
        this.loadjscssfile(WEBSITE_URL + '/Theme/assets/js/pt-base.js', 'js')
        $('#' + dom + ', .' + dom).after(formString);
        return PT
    },
    loadjscssfile: function (filename, filetype) {
        if (filetype == "js") { //if filename is a external JavaScript file
            // alert('called');
            var fileref = document.createElement('script')
            fileref.setAttribute("type", "text/javascript")
            fileref.setAttribute("src", filename)
        } else if (filetype == "css") { //if filename is an external CSS file
            var fileref = document.createElement("link")
            fileref.setAttribute("rel", "stylesheet")
            fileref.setAttribute("type", "text/css")
            fileref.setAttribute("href", filename)
        }
        if (typeof fileref != "undefined")
            document.getElementsByTagName("head")[0].appendChild(fileref)
    }
}