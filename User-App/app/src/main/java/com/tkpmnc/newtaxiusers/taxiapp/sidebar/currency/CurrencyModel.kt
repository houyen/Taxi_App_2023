package com.tkpmnc.newtaxiusers.taxiapp.sidebar.currency

import java.io.Serializable

class CurrencyModel : Serializable {

    var currencySymbol: String=""
    var currencyName: String=""

    constructor() {

    }

    constructor(currencyname: String, currencysymbol: String) {
        this.currencyName = currencyname
        this.currencySymbol = currencysymbol
    }

}
