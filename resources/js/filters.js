import Vue from 'vue';

Vue.filter('currency', function(val) {
	return window.accounting.formatNumber(val);
});

Vue.filter('idDate',  function (val) {
	if(!val) return "";
    return moment(val, 'YYYY-MM-DD').format('DD/MM/YYYY');
});

Vue.filter('idBirth',  function (val) {
	if(!val) return "";
    return moment(val, 'YYYY-MM-DD').format('DD MMM YYYY');
});

Vue.filter('idDatetime',  function (val) {
	if(!val) return "";
    return moment(val, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY HH:mm');
});

Vue.filter('idCurrency', function(val){
	if(val == null)
        return "";
    return window.accounting.format(val,0,'.');
});

Vue.filter('length', function(val, param) {
	return val ? val.substring(0,param) : val;
});