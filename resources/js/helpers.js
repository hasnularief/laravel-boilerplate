export function getUrlParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

export function getAgeLabel(birth_date, current_time = moment()) {

    var ageyear = moment(current_time).diff(birth_date, "years",true);
    var agemonth = moment(current_time).diff(birth_date, "years",true);
    var ageday = moment(current_time).diff(birth_date, "days",true);

    if(ageyear >= 1)
        return parseInt(ageyear,0) + " tahun";
    else if(agemonth >= 1)
        return parseInt(agemonth,0) + " bulan";
    else
        return parseInt(ageday,0) + " hari";
}


export function idCurrency(bill) {
    if(bill == null)
        return "";
    return window.accounting.format(bill,0,'.');
}

export function openWindowWithPost(url, params, name = 'name', windowoption = 'height=500,width=800,top=50,left=50') {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", url);
    form.setAttribute("target", name);

    var csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = window.Laravel.csrfToken;
    form.appendChild(csrf);
 
    for (var i in params) {
        if (params.hasOwnProperty(i)) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = i;
            input.value = (params[i] instanceof Object) ? JSON.stringify(params[i]) : params[i];
            form.appendChild(input);
        }
    }
            
    document.body.appendChild(form);
    window.open(url, name, windowoption);
            
    form.submit();
            
    document.body.removeChild(form);
}