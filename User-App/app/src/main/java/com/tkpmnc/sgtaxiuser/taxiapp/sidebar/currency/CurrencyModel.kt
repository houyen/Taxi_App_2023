package com.tkpmnc.sgtaxiuser.taxiapp.sidebar.currency

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
