/******************************************************************
* render layout to hidden iframe and print
* based on 
* https://gist.github.com/Rahim373/e427b51159e561809bfa21ba42b6be3f
******************************************************************/

function closePrint() {

    // Remove iframe from the DOM

    document.body.removeChild(this.__container__);
}

function setPrint() {

    // Set print functionality

    this.contentWindow.__container__ = this;
    this.contentWindow.onbeforeunload = closePrint;
    this.contentWindow.onafterprint = closePrint;
    this.contentWindow.focus(); // Required for IE

    var result = this.contentWindow.document.execCommand('print', true, null);
    if (!result) {
        this.contentWindow.print();
    }
}

function printPage(sURL) {

    // Print an external url
    // @param {string} sURL url

    var oHiddFrame = document.createElement("iframe");
    oHiddFrame.onload = setPrint;
    oHiddFrame.style.visibility = "visible";
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.style.height = "0";
    oHiddFrame.style.width = "0";
    oHiddFrame.srcdoc = render_plate();
    //oHiddFrame.src = sURL;
    document.body.appendChild(oHiddFrame);
}