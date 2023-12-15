package com.tkpmnc.sgtaxiuser.appcommon.configs

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage configs
 * @category SessionManager
 * 
 * 
 */

import android.content.SharedPreferences
import com.tkpmnc.sgtaxiuser.appcommon.network.AppController
import javax.inject.Inject

/*****************************************************************
 * Session manager to set and get glopal values
 */
@Suppress("NULLABILITY_MISMATCH_BASED_ON_JAVA_ANNOTATIONS")
class SessionManager {
    @Inject
    lateinit var sharedPreferences: SharedPreferences

    init {
        AppController.appComponent.inject(this)
    }

    var token: String?
        get() = sharedPreferences.getString("token", "")
        set(token) = sharedPreferences.edit().putString("token", token).apply()

    var accessToken: String?
        get() = sharedPreferences.getString("access_token", "")
        set(accessToken) = sharedPreferences.edit().putString("access_token", accessToken).apply()

    var firebaseCustomToken: String?
        get() = sharedPreferences.getString("firebaseCustomToken", "")
        set(firebaseCustomToken) = sharedPreferences.edit().putString("firebaseCustomToken", firebaseCustomToken).apply()

    var defaultPayment: String?
        get() = sharedPreferences.getString("defaultPayment", "")
        set(defaultPayment) = sharedPreferences.edit().putString("defaultPayment", defaultPayment).apply()

    var isFirebaseTokenUpdated: Boolean
        get() = sharedPreferences.getBoolean("isFirebaseTokenUpdated", false)
        set(isFirebaseTokenUpdated) = sharedPreferences.edit().putBoolean("isFirebaseTokenUpdated", isFirebaseTokenUpdated).apply()

    var dialCode: String?
        get() = sharedPreferences.getString("dialCode", "")
        set(dialCode) = sharedPreferences.edit().putString("dialCode", dialCode).apply()

    var googleMapKey: String?
        get() = sharedPreferences.getString("google_map_key", "")
        set(google_map_key) = sharedPreferences.edit().putString("google_map_key", google_map_key).apply()

    var scheduleDateTime: String?
        get() = sharedPreferences.getString("date_time_for_schedule", "")
        set(date_time_to_save) = sharedPreferences.edit().putString("date_time_for_schedule", date_time_to_save).apply()

    var scheduleDate: String?
        get() = sharedPreferences.getString("date_for_schedule", "")
        set(date_for_schedule) = sharedPreferences.edit().putString("date_for_schedule", date_for_schedule).apply()

    var presentTime: String?
        get() = sharedPreferences.getString("present_time_for_schedule", "")
        set(present_time_for_schedule) = sharedPreferences.edit().putString("present_time_for_schedule", present_time_for_schedule).apply()

    var carName: String?
        get() = sharedPreferences.getString("carname", "")
        set(carname) = sharedPreferences.edit().putString("carname", carname).apply()

    var pushJson: String?
        get() = sharedPreferences.getString("json", "")
        set(PushJson) = sharedPreferences.edit().putString("json", PushJson).apply()

    var type: String?
        get() = sharedPreferences.getString("type", "")
        set(type) = sharedPreferences.edit().putString("type", type).apply()


    var requestId: String?
        get() = sharedPreferences.getString("requestId", "")
        set(PushJson) = sharedPreferences.edit().putString("requestId", PushJson).apply()

    var deviceType: String?
        get() = sharedPreferences.getString("devicetype", "")
        set(devicetype) = sharedPreferences.edit().putString("devicetype", devicetype).apply()

    var isDriverAndRiderAbleToChat: Boolean
        get() = sharedPreferences.getBoolean("setDriverAndRiderAbleToChat", false)
        set(status) = sharedPreferences.edit().putBoolean("setDriverAndRiderAbleToChat", status).apply()

    var language: String?
        get() = sharedPreferences.getString("language", "")
        set(language) = sharedPreferences.edit().putString("language", language).apply()

    var languageCode: String?
        get() = sharedPreferences.getString("languagecode", "")
        set(languagecode) = sharedPreferences.edit().putString("languagecode", languagecode).apply()

    var bookingType: String?
        get() = sharedPreferences.getString("bookingType", "")
        set(bookingType) = sharedPreferences.edit().putString("bookingType", bookingType).apply()

    var facebookId: String?
        get() = sharedPreferences.getString("facebookid", "")
        set(facebookid) = sharedPreferences.edit().putString("facebookid", facebookid).apply()

    var appleId: String?
        get() = sharedPreferences.getString("appleid", "")
        set(appleid) = sharedPreferences.edit().putString("appleid", appleid).apply()

    var googleId: String?
        get() = sharedPreferences.getString("googleid", "")
        set(languagecode) = sharedPreferences.edit().putString("googleid", languagecode).apply()

    var profilepicture: String?
        get() = sharedPreferences.getString("profilepicture", "")
        set(gender) = sharedPreferences.edit().putString("profilepicture", gender).apply()

    var currency: String?
        get() = sharedPreferences.getString("currency", "")
        set(currency) = sharedPreferences.edit().putString("currency", currency).apply()

    var firstName: String?
        get() = sharedPreferences.getString("firstname", "")
        set(firstName) = sharedPreferences.edit().putString("firstname", firstName).apply()

    var lastName: String?
        get() = sharedPreferences.getString("lastname", "")
        set(lastName) = sharedPreferences.edit().putString("lastname", lastName).apply()



    var password: String?
        get() = sharedPreferences.getString("password", "")
        set(password) = sharedPreferences.edit().putString("password", password).apply()

    var phoneNumber: String?
        get() = sharedPreferences.getString("phoneNumber", "")
        set(phoneNumber) = sharedPreferences.edit().putString("phoneNumber", phoneNumber).apply()

    // this is temporary phone number and country code, this data will passed to facebook account kit
    var temporaryPhonenumber: String?
        get() = sharedPreferences.getString("TemporaryPhonenumber", "")
        set(phoneNumber) = sharedPreferences.edit().putString("TemporaryPhonenumber", phoneNumber).apply()

    var temporaryCountryCode: String?
        get() = sharedPreferences.getString("TemporaryCountryCode", "")
        set(countryCode) = sharedPreferences.edit().putString("TemporaryCountryCode", countryCode).apply()

    var countryCode: String?
        get() = sharedPreferences.getString("countryCode", "")
        set(countryCode) = sharedPreferences.edit().putString("countryCode", countryCode).apply()

    var deviceId: String?
        get() = sharedPreferences.getString("deviceId", "")
        set(deviceId) = sharedPreferences.edit().putString("deviceId", deviceId).apply()

    var tripId: String?
        get() = sharedPreferences.getString("tripId", "")
        set(tripId) = sharedPreferences.edit().putString("tripId", tripId).apply()

    var isUpdateLocation: Int
        get() = sharedPreferences.getInt("isupldatelocation", 0)
        set(isupldatelocation) = sharedPreferences.edit().putInt("isupldatelocation", isupldatelocation).apply()

    var issignin: Int
        get() = sharedPreferences.getInt("issignin", 0)
        set(issignin) = sharedPreferences.edit().putInt("issignin", issignin).apply()

    var tripStatus: String?
        get() = sharedPreferences.getString("tripStatus", "")
        set(tripStatus) = sharedPreferences.edit().putString("tripStatus", tripStatus).apply()

    var currencyCode: String?
        get() = sharedPreferences.getString("currencyCode", "")
        set(currencyCode) = sharedPreferences.edit().putString("currencyCode", currencyCode).apply()

    var currencySymbol: String?
        get() = sharedPreferences.getString("currencysymbol", "")
        set(currencySymbol) = sharedPreferences.edit().putString("currencysymbol", currencySymbol).apply()

    var homeAddress: String?
        get() = sharedPreferences.getString("homeadresstext", "")
        set(homeadresstext) = sharedPreferences.edit().putString("homeadresstext", homeadresstext).apply()

    var workAddress: String?
        get() = sharedPreferences.getString("workadresstext", "")
        set(workadresstext) = sharedPreferences.edit().putString("workadresstext", workadresstext).apply()

    var profileDetail: String?
        get() = sharedPreferences.getString("profilearratdetail", "")
        set(profilearratdetail) = sharedPreferences.edit().putString("profilearratdetail", profilearratdetail).apply()

    var paymentMethodDetail: String?
        get() = sharedPreferences.getString("paymentMethodDetail", "")
        set(paymentMethodDetail) = sharedPreferences.edit().putString("paymentMethodDetail", paymentMethodDetail).apply()

    var paymentMethod: String?
        get() = sharedPreferences.getString("paymentMethod", "")
        set(paymentMethod) = sharedPreferences.edit().putString("paymentMethod", paymentMethod).apply()

    var paymentMethodkey: String?
        get() = sharedPreferences.getString("paymentMethodkey", "")
        set(paymentMethodkey) = sharedPreferences.edit().putString("paymentMethodkey", paymentMethodkey).apply()

    var paymentMethodImage: String?
        get() = sharedPreferences.getString("paymentMethodImage", "")
        set(paymentMethodImage) = sharedPreferences.edit().putString("paymentMethodImage", paymentMethodImage).apply()

    var isrequest: Boolean
        get() = sharedPreferences.getBoolean("isrequest", false)
        set(isrequest)= sharedPreferences.edit().putBoolean("isrequest",isrequest).apply()

    var Vip: String?
        get() = sharedPreferences.getString("Vip", "")
        set(Vip) = sharedPreferences.edit().putString("Vip", Vip).apply()

    var isTrip: Boolean
        get() = sharedPreferences.getBoolean("istrip", false)
        set(istrip)= sharedPreferences.edit().putBoolean("istrip",istrip).apply()

    var driverProfilePic: String?
        get() = sharedPreferences.getString("driverProfilePic", "")
        set(url) = sharedPreferences.edit().putString("driverProfilePic", url).apply()

    var driverId: String?
        get() = sharedPreferences.getString("driverID", "")
        set(url) = sharedPreferences.edit().putString("driverID", url).apply()

    var driverRating: String?
        get() = sharedPreferences.getString("driverRatingValue", "")
        set(ratingvalue) = sharedPreferences.edit().putString("driverRatingValue", ratingvalue).apply()

    var driverName: String?
        get() = sharedPreferences.getString("driverName", "")
        set(drivername) = sharedPreferences.edit().putString("driverName", drivername).apply()

    var adminContact: String?
        get() = sharedPreferences.getString("AdminContact", "")
        set(AdminContact) = sharedPreferences.edit().putString("AdminContact", AdminContact).apply()

    var userId: String?
        get() = sharedPreferences.getString("UserId", "")
        set(UserId) = sharedPreferences.edit().putString("UserId", UserId).apply()

    var scheduledDateAndTime: String?
        get() = sharedPreferences.getString("ScheduledDateAndTime", "")
        set(ScheduledDateAndTime) = sharedPreferences.edit().putString("ScheduledDateAndTime", ScheduledDateAndTime).apply()

    var sinchKey: String?
        get() = sharedPreferences.getString("weasqr", "")
        set(sinchKey) = sharedPreferences.edit().putString("weasqr", sinchKey).apply()

    var sinchSecret: String?
        get() = sharedPreferences.getString("udueuw", "")
        set(sinchSecret) = sharedPreferences.edit().putString("udueuw", sinchSecret).apply()

    var brainTreeClientToken: String?
        get() = sharedPreferences.getString("BrainTreeClientToken", "")
        set(BrainTreeClientToken) = sharedPreferences.edit().putString("BrainTreeClientToken", BrainTreeClientToken).apply()

    var email: String?
        get() = sharedPreferences.getString("email", "")
        set(email) = sharedPreferences.edit().putString("email", email).apply()

    fun clearToken() {
        sharedPreferences.edit().putString("token", "").apply()
    }

    fun clearPaymentType() {
        sharedPreferences.edit().putString("paymentMethod", "").apply()
        sharedPreferences.edit().putString("paymentMethodImage", "").apply()
    }
    fun clearAll() {
        sharedPreferences.edit().clear().apply()
        type = "2"
    }

    fun clearTripID() {
        sharedPreferences.edit().remove("tripId").apply()
    }


    var currentAddress: String?
        get() = sharedPreferences.getString("currentAddress", "")
        set(currentAddress) = sharedPreferences.edit().putString("currentAddress", currentAddress).apply()

    fun clearDriverNameRatingAndProfilePicture() {
        val editor = sharedPreferences.edit()
        editor.remove("driverRatingValue")
        editor.remove("driverName")
        editor.remove("driverProfilePic")
        editor.apply()
    }
}