package com.tkpmnc.sgtaxiusers.taxiapp.firebase_auth

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.EditText
import android.widget.Toast
import androidx.cardview.widget.CardView
import androidx.constraintlayout.widget.ConstraintLayout
import androidx.core.content.ContextCompat
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.google.firebase.FirebaseException
import com.google.firebase.FirebaseTooManyRequestsException
import com.google.firebase.auth.*
import com.hbb20.CountryCodePicker
import com.tkpmnc.sgtaxiusers.R
import com.tkpmnc.sgtaxiusers.appcommon.network.AppController
import com.tkpmnc.sgtaxiusers.appcommon.utils.CommonMethods
import com.tkpmnc.sgtaxiusers.taxiapp.firebase_auth.OTPActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.main.MainActivity
import com.tkpmnc.sgtaxiusers.taxiapp.views.signinsignup.SSRegisterActivity
import java.util.concurrent.TimeUnit
import javax.inject.Inject

class PhoneActivity : AppCompatActivity() {

    private lateinit var sendOTPBtn : CardView
    private lateinit var phoneNumberET : EditText
    private lateinit var auth : FirebaseAuth
    private lateinit var number : String
    private  lateinit var phoneNumber : String
    private lateinit var code : String

    @BindView(R.id.ccp)
    lateinit var ccp: CountryCodePicker

    @BindView(R.id.cl_otp_input)
    lateinit var ctlOTP: ConstraintLayout
    @BindView(R.id.phone)
    lateinit var edtxPhoneNumber: EditText
    @BindView(R.id.fab_verify)
    lateinit var cvNext: CardView
    @Inject
    lateinit var commonMethods: CommonMethods

    @OnClick(R.id.back)
    fun showPhoneNumberField() {
        if (ctlOTP.visibility == View.VISIBLE) {
            if (phoneNumberET.text.toString().length > 8) {
                cvNext.setCardBackgroundColor(ContextCompat.getColor(applicationContext, R.color.newtaxi_app_yellow))
                //cvvNext.setCardBackgroundColor(ContextCompat.getColor(applicationContext,R.color.light_blue_button_color))
                //cvNext.setCardBackgroundColor(resources.getColor(R.color.light_blue_button_color))
            } else {
                //cvNext.setCardBackgroundColor(resources.getColor(R.color.quantum_grey400))
                cvNext.setCardBackgroundColor(ContextCompat.getColor(applicationContext, R.color.newtaxi_app_yellow_disable))
                //cvvNext.setCardBackgroundColor(ContextCompat.getColor(applicationContext,R.color.quantum_grey400))
            }
        } else {
            /* val intent = Intent(this, SigninSignupActivity::class.java)
             startActivity(intent)
             overridePendingTransition(R.anim.ub__slide_in_right,R.anim.ub__slide_out_left)
             finish()*/
            super.onBackPressed()
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_phone_verification)
        ButterKnife.bind(this)
        AppController.appComponent.inject(this)
        ccp.setAutoDetectedCountry(true)
        init()
        sendOTPBtn.setOnClickListener {
            number = phoneNumberET.text.trim().toString()
            phoneNumber  = phoneNumberET.text.trim().toString()
            code = ccp.selectedCountryCodeWithPlus
            if (number.isNotEmpty() && code.isNotEmpty()){
                if (number.length == 9){
                    number = "$code$number"
                    commonMethods.showProgressDialog(this)
                    val options = PhoneAuthOptions.newBuilder(auth)
                        .setPhoneNumber(number)       // Phone number to verify
                        .setTimeout(60L, TimeUnit.SECONDS) // Timeout and unit
                        .setActivity(this)                 // Activity (for callback binding)
                        .setCallbacks(callbacks) // OnVerificationStateChangedCallbacks
                        .build()
                    PhoneAuthProvider.verifyPhoneNumber(options)

                }else{
                    Toast.makeText(this , "Please Enter correct Number" , Toast.LENGTH_SHORT).show()
                }
            }else{
                Toast.makeText(this , "Please Enter Number" , Toast.LENGTH_SHORT).show()

            }
        }
    }

    private fun init(){
        commonMethods.hideProgressDialog()
        sendOTPBtn = findViewById(R.id.fab_verify)
        phoneNumberET = findViewById(R.id.phone)
        auth = FirebaseAuth.getInstance()
    }

    private fun signInWithPhoneAuthCredential(credential: PhoneAuthCredential) {
        auth.signInWithCredential(credential)
            .addOnCompleteListener(this) { task ->
                if (task.isSuccessful) {
                    // Sign in success, update UI with the signed-in user's information
                    Toast.makeText(this , "Authenticate Successfully" , Toast.LENGTH_SHORT).show()
                    sendToMain()
                } else {
                    // Sign in failed, display a message and update the UI
                    Log.d("TAG", "signInWithPhoneAuthCredential: ${task.exception.toString()}")
                    if (task.exception is FirebaseAuthInvalidCredentialsException) {
                        // The verification code entered was invalid
                    }
                    // Update UI
                }
                commonMethods.hideProgressDialog()
            }
    }

    private fun sendToMain(){
        startActivity(Intent(this , SSRegisterActivity::class.java))
    }
    private val callbacks = object : PhoneAuthProvider.OnVerificationStateChangedCallbacks() {

        override fun onVerificationCompleted(credential: PhoneAuthCredential) {
            // This callback will be invoked in two situations:
            // 1 - Instant verification. In some cases the phone number can be instantly
            //     verified without needing to send or enter a verification code.
            // 2 - Auto-retrieval. On some devices Google Play services can automatically
            //     detect the incoming verification SMS and perform verification without
            //     user action.
            signInWithPhoneAuthCredential(credential)
        }

        override fun onVerificationFailed(e: FirebaseException) {
            // This callback is invoked in an invalid request for verification is made,
            // for instance if the the phone number format is not valid.

            if (e is FirebaseAuthInvalidCredentialsException) {
                // Invalid request
                Log.d("TAG", "onVerificationFailed: ${e.toString()}")
            } else if (e is FirebaseTooManyRequestsException) {
                // The SMS quota for the project has been exceeded
                Log.d("TAG", "onVerificationFailed: ${e.toString()}")
            }
            commonMethods.showProgressDialog(this@PhoneActivity)
            // Show a message and update the UI
        }

        override fun onCodeSent(
            verificationId: String,
            token: PhoneAuthProvider.ForceResendingToken
        ) {
            // The SMS verification code has been sent to the provided phone number, we
            // now need to ask the user to enter the code and then construct a credential
            // by combining the code with a verification ID.
            // Save verification ID and resending token so we can use them later
            val intent = Intent(this@PhoneActivity , OTPActivity::class.java)
            intent.putExtra("OTP" , verificationId)
            intent.putExtra("resendToken" , token)
            intent.putExtra("phoneNumber" , number)
            //Get Mobile Number without Country Code
            intent.putExtra("mobile_number",phoneNumber)
            intent.putExtra("country_code",ccp.selectedCountryCode)
            intent.putExtra("country_code_name",ccp.selectedCountryNameCode)
            startActivity(intent)

            commonMethods.hideProgressDialog()
        }
    }

    override fun onBackPressed() {
        //if (isPhoneNumberLayoutIsVisible) {
            super.onBackPressed()
        //} else {
            //showPhoneNumberField()
       // }
    }
    /*override fun onStart() {
        super.onStart()
        if (auth.currentUser != null){
            startActivity(Intent(this , PhoneActivity::class.java))
        }
    }*/
}