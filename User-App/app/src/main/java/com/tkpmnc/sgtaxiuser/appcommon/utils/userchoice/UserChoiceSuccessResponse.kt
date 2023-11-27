package com.tkpmnc.sgtaxiuser.appcommon.utils.userchoice

interface UserChoiceSuccessResponse {
    fun onSuccessUserSelected(type: String?, userChoiceData: String?, userChoiceCode: String?)
}