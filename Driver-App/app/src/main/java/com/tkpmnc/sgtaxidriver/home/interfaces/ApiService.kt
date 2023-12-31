package com.tkpmnc.sgtaxidriver.home.interfaces

import okhttp3.RequestBody
import okhttp3.ResponseBody
import retrofit2.Call
import retrofit2.http.*
import java.util.*

/* ************************************************************
                      ApiService
    Contains all api service call methods
*************************************************************** */

interface ApiService {

    // login numbervalidation

    // Upload Documents image
    @POST("document_upload")
    fun uploadDocumentImage(@Body RequestBody: RequestBody, @Query("token") token: String): Call<ResponseBody>

    @POST("update_document")
    fun updateDocument(@Body RequestBody: RequestBody, @Query("token") token: String): Call<ResponseBody>

    // Upload Profile image
    @POST("upload_profile_image")
    fun uploadProfileImage(@Body RequestBody: RequestBody, @Query("token") token: String): Call<ResponseBody>


    // Update location with lat,lng
    @GET("send_message")
    fun updateChat(@QueryMap hashMap: HashMap<String, String>): Call<ResponseBody>

    //Login
    @GET("login")
    fun login(@Query("mobile_number") mobilenumber: String, @Query("user_type") usertype: String, @Query("country_code") countrycode: String, @Query("password") password: String, @Query("device_id") deviceid: String, @Query("device_type") devicetype: String, @Query("language") language: String): Call<ResponseBody>

    //Login
    @GET("vehicle_details")
    fun vehicleDetails(@Query("vehicle_id") vehicleid: Long, @Query("vehicleName") vehiclename: String, @Query("vehicle_type") vehicletype: String, @Query("vehicle_number") vehiclenumber: String, @Query("token") token: String): Call<ResponseBody>

    //Forgot password
    @GET("forgotpassword")
    fun forgotpassword(@Query("mobile_number") mobile_number: String, @Query("user_type") user_type: String, @Query("country_code") country_code: String, @Query("password") password: String, @Query("device_type") device_type: String, @Query("device_id") device_id: String, @Query("language") language: String): Call<ResponseBody>

    //Number Validation
    @GET("numbervalidation")
    fun numberValidation(@Query("user_type") type: String, @Query("mobile_number") mobilenumber: String, @Query("country_code") countrycode: String, @Query("forgotpassword") forgotpassword: String, @Query("language") language: String): Call<ResponseBody>

    //Cancel trip
    @GET("cancel_trip")
    fun cancelTrip(@Query("user_type") type: String, @Query("cancel_reason_id") cancel_reason: String, @Query("cancel_comments") cancel_comments: String, @Query("trip_id") trip_id: String, @Query("token") token: String): Call<ResponseBody>


    // Cancel Reason
    @GET("cancel_reasons")
    fun cancelReasons(@Query("token") token: String): Call<ResponseBody>

    //Forgot password
    @GET("accept_request")
    fun acceptRequest(@Query("user_type") type: String, @Query("request_id") request_id: String, @Query("status") status: String, @Query("token") token: String,@Query("timezone") timezone:String): Call<ResponseBody>


    //Forgot password
    @GET("vehicle_descriptions")
    fun getVehicleDescription(@Query("token") token: String): Call<ResponseBody>


    @FormUrlEncoded
    @POST("update_vehicle")
    fun updateVehicle(@FieldMap hashMap: LinkedHashMap<String, String>): Call<ResponseBody>

    //Confirm Arrival
    @GET("cash_collected")
    fun cashCollected(@Query("trip_id") trip_id: String, @Query("token") token: String): Call<ResponseBody>


    //Default vehicle
    @GET("update_default_vehicle")
    fun updateDefaultVehicle(@Query("vehicle_id") vehicle_id: String, @Query("token") token: String): Call<ResponseBody>

    //Confirm Arrival
    @GET("arive_now")
    fun ariveNow(@Query("trip_id") trip_id: String, @Query("token") token: String): Call<ResponseBody>

    //Begin Trip
    @GET("begin_trip")
    fun beginTrip(@Query("trip_id") trip_id: String, @Query("begin_latitude") begin_latitude: String, @Query("begin_longitude") begin_longitude: String, @Query("token") token: String): Call<ResponseBody>

    //End Trip
    @POST("end_trip")
    fun endTrip(@Body RequestBody: RequestBody): Call<ResponseBody>

    //Trip Rating
    @GET("trip_rating")
    fun tripRating(@Query("trip_id") trip_id: String, @Query("rating") rating: String,
                   @Query("rating_comments") rating_comments: String, @Query("user_type") user_type: String, @Query("token") token: String): Call<ResponseBody>


    // Update location with lat,lng and driverStatus
    @GET("updatelocation")
    fun updateLocation(@QueryMap hashMap: HashMap<String, String>): Call<ResponseBody>


    @GET("update_device")
    fun updateDevice(@QueryMap hashMap: HashMap<String, String>): Call<ResponseBody>


    // driverStatus Check
    @GET("check_status")
    fun updateCheckStatus(@QueryMap hashMap: HashMap<String, String>): Call<ResponseBody>

    @GET("driver_rating")
    fun updateDriverRating(@QueryMap hashMap: HashMap<String, String>): Call<ResponseBody>

    @GET("rider_feedback")
    fun updateRiderFeedBack(@QueryMap hashMap: HashMap<String, String>): Call<ResponseBody>


    //Number Validation
    @GET("register")
    fun registerOtp(@Query("user_type") type: String, @Query("mobile_number") mobilenumber: String, @Query("country_code") countrycode: String, @Query("email_id") emailid: String, @Query("first_name") first_name: String, @Query("last_name") last_name: String, @Query("password") password: String, @Query("city") city: String, @Query("device_id") device_id: String, @Query("device_type") device_type: String, @Query("language") languageCode: String, @Query("referral_code") referral: String?,@Query("auth_type") authType : String,@Query("auth_id") authId : String,@Query("gender") gender : String): Call<ResponseBody>


    //Driver Profile
    @GET("get_driver_profile")
    fun getDriverProfile(@Query("token") token: String): Call<ResponseBody>


    //language Update
    @GET("language")
    fun language(@Query("language") languageCode: String, @Query("token") token: String): Call<ResponseBody>

    @GET("update_driver_profile")
    fun updateDriverProfile(@QueryMap hashMap: LinkedHashMap<String, String>): Call<ResponseBody>

    //Sign out
    @GET("logout")
    fun logout(@Query("user_type") type: String, @Query("token") token: String): Call<ResponseBody>

    //Force Update API
    @GET("check_version")
    fun checkVersion(@Query("version") code: String, @Query("user_type") type: String, @Query("device_type") deviceType: String): Call<ResponseBody>

    //Check user Mobile Number
    @GET("numbervalidation")
    fun numbervalidation(@Query("mobile_number") mobile_number: String, @Query("country_code") country_code: String, @Query("user_type") user_type: String, @Query("language") language: String, @Query("forgotpassword") forgotpassword: String): Call<ResponseBody>

    //Heat map
    @GET("heat_map")
    fun heatMap(@Query("token") token: String, @Query("timezone") timeZone: String): Call<ResponseBody>

    //Common Data
    @POST("common_data")
    fun commonData(@Query("token") token: String): Call<ResponseBody>

    // get profile picture and name of opponent caller for sinch call page
    @GET("get_caller_detail")
    fun getCallerDetail(@Query("token") token: String, @Query("user_id") userID: String, @Query("send_push_notification") pushStatus: String): Call<ResponseBody>

    // Get given trip details
    @GET("get_trip_details")
    fun getTripDetails(@Query("token") token: String, @Query("trip_id") trip_id: String): Call<ResponseBody>

    // Get completed trip list
    @GET("get_completed_trips")
    fun getPastTrips(@Query("token") token: String, @Query("page") page: String): Call<ResponseBody>

    //pending
    @GET("get_pending_trips")
    fun getPendingTrips(@Query("token") token: String, @Query("page") page: String): Call<ResponseBody>

}


