@file:Suppress("RECEIVER_NULLABILITY_MISMATCH_BASED_ON_JAVA_ANNOTATIONS")

package com.tkpmnc.sgtaxiuser.taxiapp.sidebar

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage Side_Bar
 * @category Profile
 * 
 * 
 */

import android.app.Activity
import android.content.Context
import android.content.Intent
import android.graphics.Bitmap
import android.graphics.BitmapFactory
import android.net.Uri
import android.os.Build
import android.os.Bundle
import android.os.Environment
import android.provider.MediaStore
import android.text.Editable
import android.text.TextUtils
import android.text.TextWatcher
import android.view.View
import android.view.inputmethod.InputMethodManager
import android.widget.*
import androidx.appcompat.app.AlertDialog
import androidx.core.content.ContextCompat
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.google.android.material.bottomsheet.BottomSheetDialog
import com.google.gson.Gson
import com.hbb20.CountryCodePicker
import com.squareup.picasso.Picasso
import com.tkpmnc.sgtaxiuser.R
import com.tkpmnc.sgtaxiuser.appcommon.backgroundtask.ImageCompressAsyncTask
import com.tkpmnc.sgtaxiuser.appcommon.configs.RunTimePermission
import com.tkpmnc.sgtaxiuser.appcommon.configs.SessionManager
import com.tkpmnc.sgtaxiuser.appcommon.datamodels.JsonResponse
import com.tkpmnc.sgtaxiuser.appcommon.helper.Constants.Female
import com.tkpmnc.sgtaxiuser.appcommon.helper.Constants.Male
import com.tkpmnc.sgtaxiuser.appcommon.helper.Constants.PICK_IMAGE_REQUEST_CODE
import com.tkpmnc.sgtaxiuser.appcommon.helper.Constants.SELECT_FILE
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ApiService
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ImageListener
import com.tkpmnc.sgtaxiuser.appcommon.interfaces.ServiceListener
import com.tkpmnc.sgtaxiuser.appcommon.network.AppController
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonKeys
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonKeys.FACEBOOK_ACCOUNT_KIT_PHONE_NUMBER_KEY
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods.Companion.DebuggableLogI
import com.tkpmnc.sgtaxiuser.appcommon.utils.CommonMethods.Companion.DebuggableLogV
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_GET_RIDER_PROFILE
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_UPDATE_PROFILE
import com.tkpmnc.sgtaxiuser.appcommon.utils.Enums.REQ_UPLOAD_PROFILE_IMG
import com.tkpmnc.sgtaxiuser.appcommon.utils.RequestCallback
import com.tkpmnc.sgtaxiuser.appcommon.utils.RuntimePermissionDialogFragment
import com.tkpmnc.sgtaxiuser.appcommon.views.CommonActivity
import com.tkpmnc.sgtaxiuser.taxiapp.datamodels.RiderProfile
import com.tkpmnc.sgtaxiuser.taxiapp.firebase_auth.PhoneActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.customize.CustomDialog
import com.tkpmnc.sgtaxiuser.taxiapp.views.facebookAccountKit.FacebookAccountKitActivity
import com.tkpmnc.sgtaxiuser.taxiapp.views.splash.SplashActivity
import kotlinx.android.synthetic.main.app_activity_add_wallet.*
import okhttp3.RequestBody
import org.json.JSONException
import org.json.JSONObject
import java.io.*
import java.util.*
import javax.inject.Inject


/* ************************************************************
   Rider profile details page
    *********************************************************** */

class Profile : CommonActivity(), ServiceListener, ImageListener, RuntimePermissionDialogFragment.RuntimePermissionRequestedCallback {

    lateinit var dialog: AlertDialog
    @Inject
    lateinit var sessionManager: SessionManager
    @Inject
    lateinit var commonMethods: CommonMethods
    @Inject
    lateinit var apiService: ApiService
    @Inject
    lateinit var customDialog: CustomDialog
    @Inject
    lateinit var runTimePermission: RunTimePermission
    @Inject
    lateinit var gson: Gson
    @BindView(R.id.savebutton)
    lateinit var savebutton: Button // Save button
    @BindView(R.id.mobilenumber)
    lateinit var mobilenumber: TextView  // Mobile number
    @BindView(R.id.profile_image1)
    lateinit var profile_image: ImageView  // Profile image view
    @BindView(R.id.mobile_code)
    lateinit var ccp: CountryCodePicker  // Country code picker
    lateinit var firstnamegettext: String
    lateinit var lastnamegettext: String
    lateinit var emailgettext: String  // First, Last, Email text string
    @BindView(R.id.emaitext)
    lateinit var emaitext: EditText
    @BindView(R.id.input_first)
    lateinit var input_first: EditText
    @BindView(R.id.input_last)
    lateinit var input_last: EditText
    @BindView(R.id.common_profile)
    lateinit var commonProfile : View

    @BindView(R.id.rg_gender)
    lateinit var radiogroupGender: RadioGroup

    private var gender:String? = null

    var bm: Bitmap ?=null// Image bitmap
    lateinit var imagepath: String  // Image file path
    lateinit var imageInSD: String  // Store image in SD Card
    lateinit var image: File   // image file
    lateinit var imageUr: String  // Profile image url
    protected var isInternetAvailable: Boolean = false  // Check Network available or not
    private var imageFile: File? = null
    private val imageUri: Uri? = null

    @OnClick(R.id.phonelayout)
    fun mobileclick() {
        //FacebookAccountKitActivity.openFacebookAccountKitActivity(this, 0)
        if (SplashActivity.checkVersionModel.otpEnabled) {
            if(SplashActivity.checkVersionModel.defaultOtp=="firebase"){
                val signin = Intent(this, PhoneActivity::class.java)
                startActivity(signin)
            }else if(SplashActivity.checkVersionModel.defaultOtp=="twilio"){
                FacebookAccountKitActivity.openFacebookAccountKitActivity(this, 0)
            }
        }else{
            FacebookAccountKitActivity.openFacebookAccountKitActivity(this, 0)
        }
    }
    @OnClick(R.id.mobilenumber)
    fun mobileclick1() {
        //FacebookAccountKitActivity.openFacebookAccountKitActivity(this, 0)
        if (SplashActivity.checkVersionModel.otpEnabled) {
            if(SplashActivity.checkVersionModel.defaultOtp=="firebase"){
                val signin = Intent(this, PhoneActivity::class.java)
                startActivity(signin)
            }else if(SplashActivity.checkVersionModel.defaultOtp=="twilio"){
                FacebookAccountKitActivity.openFacebookAccountKitActivity(this, 0)
            }
        }else{
            FacebookAccountKitActivity.openFacebookAccountKitActivity(this, 0)
        }
    }


    @OnClick(R.id.back)
    fun back() {
        onBackPressed()
    }

    @OnClick(R.id.savebutton)
    fun savebutton() {
        isInternetAvailable = commonMethods.isOnline(applicationContext)
        if (!isInternetAvailable) {
            commonMethods.showMessage(this@Profile, dialog, getString(R.string.no_connection))
        } else {

            firstnamegettext = input_first.text.toString()
            lastnamegettext = input_last.text.toString()
            emailgettext = emaitext.text.toString()


            if (!validateFirst()) {
                return
            }
            if (!validateLast()) {
                return
            }
            if (!validateEmail()) {
              //  emailName.error = getString(R.string.error_msg_email)
                return
            }

            try {
                val imm = getSystemService(Context.INPUT_METHOD_SERVICE) as InputMethodManager
                imm.hideSoftInputFromWindow(currentFocus?.windowToken, 0)
            } catch (e: Exception) {
                e.printStackTrace()
            }

            hideSoftKeyboard()

            emaitext.isFocusableInTouchMode = true
            emaitext.isFocusable = true
            emaitext.requestFocus()

            // Update profile API Call
            updateProfile()
        }
    }

    @OnClick(R.id.edit_image)
    fun profileImage() {// Profile click listener
        pickProfileImg()
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_profile)
        ButterKnife.bind(this)
        AppController.appComponent.inject(this)
        dialog = commonMethods.getAlertDialog(this)


        /**Commmon Header Text View */
        commonMethods.setheaderText(resources.getString(R.string.editaccount),common_header)
        // Check network available or not
        isInternetAvailable = commonMethods.isOnline(applicationContext)

        input_first.addTextChangedListener(NameTextWatcher(input_first))
        input_last.addTextChangedListener(NameTextWatcher(input_last))
        emaitext.addTextChangedListener(NameTextWatcher(emaitext))

        val profiledetails = sessionManager.profileDetail.toString() // Get Profile details from JSON

        for (i in 0 until radiogroupGender.childCount) {
            radiogroupGender.getChildAt(i).isClickable = false
        }

        if (profiledetails.isEmpty() || profiledetails == "null") {
            if (!isInternetAvailable) {
                commonMethods.showMessage(this, dialog, getString(R.string.no_connection))
            } else {
                getRiderDetails() // Get JSON data From profile API
            }
        } else {
            loaddata(profiledetails) // Load Profile details
        }

    }

    fun hideSoftKeyboard() {
        if (currentFocus != null) {
            val inputMethodManager = getSystemService(Context.INPUT_METHOD_SERVICE) as InputMethodManager
            inputMethodManager.hideSoftInputFromWindow(currentFocus!!.windowToken, 0)
        }
    }

    /**
     * Back button pressed
     */
    override fun onBackPressed() {
        super.onBackPressed()
        sessionManager.profileDetail = ""
        sessionManager.phoneNumber = ""
        overridePendingTransition(R.anim.ub__slide_in_left, R.anim.ub__slide_out_right)
    }

    override fun onSuccess(jsonResp: JsonResponse, data: String) {
        commonMethods.hideProgressDialog()
        if (!jsonResp.isOnline) {
            if (!TextUtils.isEmpty(data))
                commonMethods.showMessage(this, dialog, data)
            return
        }
        when (jsonResp.requestCode) {

            // Get Rider Profile
            REQ_GET_RIDER_PROFILE -> if (jsonResp.isSuccess) {
                commonMethods.hideProgressDialog()
                onSuccessGetProf(jsonResp)
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.hideProgressDialog()
                commonMethods.showMessage(this, dialog, jsonResp.statusMsg)
            }

            // Update Rider Location
            REQ_UPDATE_PROFILE -> if (jsonResp.isSuccess) {
                commonMethods.hideProgressDialog()
                onSuccessUpdateProf(jsonResp)
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.hideProgressDialog()
                commonMethods.showMessage(this, dialog, jsonResp.statusMsg)
            }
            REQ_UPLOAD_PROFILE_IMG -> if (jsonResp.isSuccess) {
                commonMethods.hideProgressDialog()
                onSuccessProf(jsonResp)
            } else if (!TextUtils.isEmpty(jsonResp.statusMsg)) {
                commonMethods.hideProgressDialog()
                commonMethods.showMessage(this, dialog, jsonResp.statusMsg)
            }
            else -> commonMethods.hideProgressDialog()
        }
    }

    override fun onFailure(jsonResp: JsonResponse, data: String) {
        commonMethods.hideProgressDialog()
    }

    /**
     * Update rider profile details API called
     */
    fun updateProfile() {
        commonMethods.showProgressDialog(this)
        apiService.updateProfile(imageUr, firstnamegettext, lastnamegettext, ccp.selectedCountryNameCode.replace("\\+".toRegex(), ""), mobilenumber.text.toString(), emailgettext, sessionManager.accessToken.toString()).enqueue(RequestCallback(REQ_UPDATE_PROFILE, this))
    }

    private fun onSuccessGetProf(jsonResp: JsonResponse) {
        if (jsonResp.statusCode.matches("1".toRegex())) {
            sessionManager.profileDetail = jsonResp.strResponse
            val riderProfile = gson.fromJson(jsonResp.strResponse, RiderProfile::class.java)
            sessionManager.walletAmount = riderProfile.walletAmount
            loaddata(jsonResp.strResponse)
        } else if (jsonResp.statusCode.matches("2".toRegex())) {
            commonMethods.showMessage(this, dialog, jsonResp.statusMsg)
        }
    }

    fun onSuccessProf(jsonResp: JsonResponse) {
        sessionManager.profileDetail = jsonResp.strResponse
        val profile_imageget = commonMethods.getJsonValue(jsonResp.strResponse, "image_url", String::class.java) as String

        imageUr = profile_imageget
        Picasso.get().load(imageUr)
                .into(profile_image)
    }

    fun onSuccessUpdateProf(jsonResp: JsonResponse) {
        sessionManager.profileDetail = jsonResp.strResponse
        val profile_imageget = commonMethods.getJsonValue(jsonResp.strResponse, "profile_image", String::class.java) as String

        imageUr = profile_imageget
        Picasso.get().load(imageUr)
                .into(profile_image)
        commonMethods.showMessage(this, dialog, jsonResp.statusMsg)
    }

    /**
     * Check Camera and gallery image data
     */

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        when (requestCode) {
            PICK_IMAGE_REQUEST_CODE -> if (resultCode == Activity.RESULT_OK) {
                if (imageFile == null) return
                imagepath = imageFile?.path!!
                if (!TextUtils.isEmpty(imagepath)) {
                    ImageCompressAsyncTask(this, imagepath, this).execute()
                }
            }
            SELECT_FILE -> try {
                val inputStream = this.contentResolver.openInputStream(data!!.data!!)
                val fileOutputStream = FileOutputStream(imageFile)
                commonMethods.copyStream(inputStream, fileOutputStream)
                fileOutputStream.close()
                inputStream?.close()
                if (imageFile == null) return
                imagepath = imageFile?.path!!
                val bm = BitmapFactory.decodeFile(imagepath)
                profile_image.setImageBitmap(bm)
                if (isInternetAvailable) {
                    ImageCompressAsyncTask(this, imagepath, this).execute()
                } else {
                    commonMethods.showMessage(this, dialog, getString(R.string.no_connection))
                }
            } catch (e: Exception) {
                e.printStackTrace()
            }
            CommonKeys.ACTIVITY_REQUEST_CODE_START_FACEBOOK_ACCOUNT_KIT -> {
                if (resultCode == Activity.RESULT_OK) {
                    updateRiderPhoneNumber(data!!.getStringExtra(FACEBOOK_ACCOUNT_KIT_PHONE_NUMBER_KEY), data.getStringExtra(CommonKeys.FACEBOOK_ACCOUNT_KIT_PHONE_NUMBER_COUNTRY_NAME_CODE_KEY)!!)
                }
            }
            else -> {
            }
        }

    }

    private fun updateRiderPhoneNumber(phoneNumber: String?, countryCode: String) {
        if (phoneNumber != null) {
            mobilenumber.text = phoneNumber
            ccp.setCountryForNameCode(countryCode)
            savebutton.isEnabled = true
        }
    }


    /**
     * convert Image bitmap to image path
     */
    fun imageWrite(bitmap: Bitmap): String {

        val extStorageDirectory = Environment.getExternalStorageDirectory().toString()
        lateinit var outStream: OutputStream
        val file = File(extStorageDirectory, "slectimage.png")
        try {
            outStream = FileOutputStream(file)
            bitmap.compress(Bitmap.CompressFormat.PNG, 100, outStream)
            outStream.flush()
            outStream.close()
        } catch (e: FileNotFoundException) {
            e.printStackTrace()
        } catch (e: IOException) {
            e.printStackTrace()
        }

        imageInSD = getString(R.string.img_src)

        return imageInSD

    }

    /**
     * Load rider profile data
     */
    fun loaddata(profiledetails: String) {
        try {
            val jsonObj = JSONObject(profiledetails)
            val first_name = jsonObj.getString("first_name")
            val last_name = jsonObj.getString("last_name")
            val mobile_number = jsonObj.getString("mobile_number")
            val email_id = jsonObj.getString("email_id")
            val is_vip = jsonObj.getString("is_vip")
            val user_thumb_image = jsonObj.getString("profile_image")
            gender = jsonObj.getString("gender")
            sessionManager.Vip = is_vip

            sessionManager.countryCode = jsonObj.getString("country_code")
            sessionManager.dialCode = jsonObj.getString("country_code")
            if (sessionManager.countryCode != "")
                ccp.setCountryForNameCode(sessionManager.countryCode)


            sessionManager.phoneNumber = jsonObj.getString("mobile_number")
            input_first.setText(first_name)
            mobilenumber.text = mobile_number
            input_last.setText(last_name)
            if ("" != email_id)
                emaitext.setText(email_id)
            imageUr = user_thumb_image

            Picasso.get().load(imageUr)
                    .into(profile_image)

            if (!gender.isNullOrEmpty()){
                if (gender.equals(Male,true)){
                    radiogroupGender.check(R.id.rd_male)

                }else if (gender.equals(Female,true)){
                    radiogroupGender.check(R.id.rd_female)
                }
            }
        } catch (e: JSONException) {
            e.printStackTrace()
        }

    }

    /**
     * Get Rider profile API called
     */
    fun getRiderDetails() {
        commonMethods.showProgressDialog(this)
        apiService.getRiderProfile(commonMethods.getRiderProfile(false,null)).enqueue(RequestCallback(REQ_GET_RIDER_PROFILE, this))

    }

    /**
     * Validate Email
     */
    private fun validateEmail(): Boolean {
        val email = emaitext.text.toString().trim { it <= ' ' }

        if (email.isEmpty() || !isValidEmail(email)) {
            return false
        }
        return true
    }

    private fun isValidEmail(email: String): Boolean {
        return !TextUtils.isEmpty(email) && android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()
    }
    private fun validateFirst(): Boolean {
        if (input_first.text.toString().trim { it <= ' ' }.isEmpty()) {
            return false
        } 
        return true
    }

  

    override fun onImageCompress(filePath: String, requestBody: RequestBody?) {
        commonMethods.hideProgressDialog()
        if (!TextUtils.isEmpty(filePath)) {


            commonMethods.showProgressDialog(this)
            apiService.uploadImage(requestBody!!, sessionManager.accessToken.toString()).enqueue(RequestCallback(REQ_UPLOAD_PROFILE_IMG, this))
        }
    }


    fun pickProfileImg() {
        val view = layoutInflater.inflate(R.layout.app_camera_dialog_layout, null)
        val lltCamera = view.findViewById<LinearLayout>(R.id.llt_camera)
        val lltLibrary = view.findViewById<LinearLayout>(R.id.llt_library)
        val lltcancel = view.findViewById<LinearLayout>(R.id.llt_cancel)

        val bottomSheetDialog = BottomSheetDialog(this, R.style.BottomSheetDialogTheme)
        bottomSheetDialog.setContentView(view)
        if (!bottomSheetDialog.isShowing) {
            bottomSheetDialog.show()
        }

        lltCamera.setOnClickListener {
            if (Build.VERSION.SDK_INT >= 33) {
                verifyAccessPermission(arrayOf(RuntimePermissionDialogFragment.CAMERA_PERMISSION, RuntimePermissionDialogFragment.READ_EXTERNAL_STORAGE_PERMISSION), RuntimePermissionDialogFragment.cameraAndGallaryCallBackCode, 0)
                bottomSheetDialog.dismiss()
            }
            else {
                verifyAccessPermission(arrayOf(RuntimePermissionDialogFragment.CAMERA_PERMISSION, RuntimePermissionDialogFragment.WRITE_EXTERNAL_STORAGE_PERMISSION), RuntimePermissionDialogFragment.cameraAndGallaryCallBackCode, 0)
                bottomSheetDialog.dismiss()
            }
        }

        lltLibrary.setOnClickListener {
            if (Build.VERSION.SDK_INT >= 33) {
                verifyAccessPermission(arrayOf(RuntimePermissionDialogFragment.READ_EXTERNAL_STORAGE_PERMISSION), RuntimePermissionDialogFragment.externalStoreageCallbackCode, 0)
                bottomSheetDialog.dismiss()
            }
            else {
                verifyAccessPermission(arrayOf(RuntimePermissionDialogFragment.WRITE_EXTERNAL_STORAGE_PERMISSION), RuntimePermissionDialogFragment.externalStoreageCallbackCode, 0)
                bottomSheetDialog.dismiss()
            }
        }
        lltcancel.setOnClickListener{
            bottomSheetDialog.dismiss()
        }
    }

    fun verifyAccessPermission(requestPermissionFor: Array<String>, requestCodeForCallbackIdentificationCode: Int, requestCodeForCallbackIdentificationCodeSubDivision: Int) {
        RuntimePermissionDialogFragment.checkPermissionStatus(this, supportFragmentManager, this, requestPermissionFor, requestCodeForCallbackIdentificationCode, requestCodeForCallbackIdentificationCodeSubDivision)
    }


    private fun pickImageFromGallary() {
        imageFile = commonMethods.getDefaultFileName(this@Profile)
        commonMethods.galleryIntent(this)
    }

    override fun permissionGranted(requestCodeForCallbackIdentificationCode: Int, requestCodeForCallbackIdentificationCodeSubDivision: Int) {
        when (requestCodeForCallbackIdentificationCode) {
            RuntimePermissionDialogFragment.cameraAndGallaryCallBackCode -> pickImageFromCamera()

            RuntimePermissionDialogFragment.externalStoreageCallbackCode -> pickImageFromGallary()

            else -> {
            }
        }
    }

    override fun permissionDenied(requestCodeForCallbackIdentificationCode: Int, requestCodeForCallbackIdentificationCodeSubDivision: Int) {
        Toast.makeText(this, "permission denied", Toast.LENGTH_SHORT).show()
    }

    private fun onImageCapturedFromCamera(data: Intent) {

        val photo = data.extras?.get("data") as Bitmap
        // CALL THIS METHOD TO GET THE URI FROM THE BITMAP
        val tempUri = getImageUri(applicationContext, photo)
        val realPath = getRealPathFromURI(tempUri)
        imagepath = getRealPathFromURI(tempUri)
        DebuggableLogI("camera image real path", realPath)
        DebuggableLogI("camera image path", imagepath)
        // CALL THIS METHOD TO GET THE ACTUAL PATH
        //File finalFile = new File(getRealPathFromURI(tempUri));


        if (!TextUtils.isEmpty(imagepath)) {
            // commonMethods.showProgressDialog(this);
            ImageCompressAsyncTask(this, imagepath, this).execute()
        }
    }

    fun getImageUri(inContext: Context, inImage: Bitmap): Uri {
        val OutImage = Bitmap.createScaledBitmap(inImage, 1000, 1000, true)
      //  val path = MediaStore.Images.Media.insertImage(inContext.contentResolver, OutImage, "Title", null)
        val path = MediaStore.Images.Media.insertImage(inContext.contentResolver, OutImage, "IMG_" + Calendar.getInstance().getTime(), null)
        return Uri.parse(path)
    }

    fun getRealPathFromURI(uri: Uri): String {
        var path = ""
        if (contentResolver != null) {
            val cursor = contentResolver.query(uri, null, null, null, null)
            if (cursor != null) {
                cursor.moveToFirst()
                val idx = cursor.getColumnIndex(MediaStore.Images.ImageColumns.DATA)
                path = cursor.getString(idx)
                cursor.close()
            }
        }
        return path
    }


    /**
     * Get gallery data
     */
    private fun onSelectFromGalleryResult(data: Intent?) {

        bm = null
        if (data != null) {
            val selectedImage = data.data
            val filePathColumn = arrayOf(MediaStore.Images.Media.DATA)

            val cursor = contentResolver.query(selectedImage!!,
                    filePathColumn, null, null, null)
            cursor?.moveToFirst()
            val columnIndex = cursor?.getColumnIndex(filePathColumn[0])
            val picturePath = cursor?.getString(columnIndex!!)
            cursor?.close()
            bm = BitmapFactory.decodeFile(picturePath)
            profile_image.setImageBitmap(bm)
            //imagepath = imageWrite(bm);

            imagepath = picturePath.toString()

            if (isInternetAvailable) {
                ImageCompressAsyncTask(this, imagepath, this).execute()
            } else {
                commonMethods.showMessage(this, dialog, getString(R.string.no_connection))
            }

        }

    }

    /**
     * Name edit text listener
     */
    private inner class NameTextWatcher(private val view: View) : TextWatcher {

        override fun beforeTextChanged(charSequence: CharSequence, i: Int, i1: Int, i2: Int) {
            DebuggableLogV("beforeTextChanged", "beforeTextChanged")
        }

        override fun onTextChanged(charSequence: CharSequence, i: Int, i1: Int, i2: Int) {
            //setting save button active when all dates are given
            if (validateFirst() && validateLast() && validateEmail()) {
                savebutton.isEnabled = true
                savebutton.setBackground(ContextCompat.getDrawable(applicationContext,R.drawable.app_curve_button_yellow))
            } else {
                savebutton.isEnabled = false
                savebutton.setBackground(ContextCompat.getDrawable(applicationContext,R.drawable.app_curve_button_yellow_disable))
            }
        }

        override fun afterTextChanged(editable: Editable) {
            when (view.id) {
                R.id.input_first -> validateFirst()
                R.id.input_last -> validateLast()
                R.id.emaitext -> validateEmail()

                R.id.mobilenumber -> {
                }
                else -> {

                }
            }// validatePhone();

        }
    }
}
