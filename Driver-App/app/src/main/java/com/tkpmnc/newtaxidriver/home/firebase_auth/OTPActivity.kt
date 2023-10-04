package com.seentechs.newtaxidriver.home.firebase_auth

import android.content.Intent
import android.os.Bundle
import android.os.CountDownTimer
import android.os.Handler
import android.os.Looper
import android.text.Editable
import android.text.TextWatcher
import android.util.Log
import android.view.View

import android.widget.*
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import androidx.core.content.ContextCompat
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.google.firebase.FirebaseException
import com.google.firebase.FirebaseTooManyRequestsException
import com.google.firebase.auth.*
import com.tkpmnc.newtaxidriver.R
import com.tkpmnc.newtaxidriver.common.network.AppController
import com.tkpmnc.newtaxidriver.common.util.CommonKeys
import com.tkpmnc.newtaxidriver.common.util.CommonMethods
import com.tkpmnc.newtaxidriver.home.signinsignup.Register
import java.util.concurrent.TimeUnit
import javax.inject.Inject

class OTPActivity : AppCompatActivity() {

    private lateinit var auth: FirebaseAuth
    private lateinit var verifyBtn: CardView
    private lateinit var resendTV: TextView
    private lateinit var inputOTP1: EditText
    private lateinit var inputOTP2: EditText
    private lateinit var inputOTP3: EditText
    private lateinit var inputOTP4: EditText
    private lateinit var inputOTP5: EditText
    private lateinit var inputOTP6: EditText


    private lateinit var OTP: String
    private lateinit var resendToken: PhoneAuthProvider.ForceResendingToken
    private lateinit var phoneNumber: String
    private lateinit var mobileNumber : String
    private lateinit var countryCode :String
    private lateinit var countryNameCode :String

    @BindView(R.id.tv_otp_resend_label)
    lateinit var tvResendOTPLabel: TextView

    @BindView(R.id.tv_otp_resend_countdown)
    lateinit var tvResendOTPCountdown: TextView

    @BindView(R.id.tv_resend_button)
    lateinit var tvResendOTP: TextView

    private var isForForgotPassword = 0
    private var otp = ""
    private lateinit var receivedOTPFromServer: String
    private val resendOTPWaitingSecond: Long = 120000
    private var resentCountdownTimer: CountDownTimer? = null
    private var backPressCounter: CountDownTimer? = null
    private var isDeletable = true
    var dialog: AlertDialog? = null
    private var isInternetAvailable: Boolean = false

    @Inject
    lateinit var commonMethods: CommonMethods

    @OnClick(R.id.back)
    fun showPhoneNumberField() {

            super.onBackPressed()

    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.app_activity_otpactivity)
        ButterKnife.bind(this)
        AppController.getAppComponent().inject(this)

        OTP = intent.getStringExtra("OTP").toString()
        resendToken = intent.getParcelableExtra("resendToken")!!
        phoneNumber = intent.getStringExtra("phoneNumber")!!
        mobileNumber = intent.getStringExtra("mobile_number")!!
        countryCode = intent.getStringExtra("country_code")!!
        countryNameCode =intent.getStringExtra("country_code_name")!!

        init()
        commonMethods.hideProgressDialog()
        addTextChangeListener()
        resendOTPTvVisibility()

        resendTV.setOnClickListener {
            resendVerificationCode()
            resendOTPTvVisibility()
        }

        verifyBtn.setOnClickListener {
            //collect otp from all the edit texts
            val typedOTP =
                (inputOTP1.text.toString() + inputOTP2.text.toString() + inputOTP3.text.toString()
                        + inputOTP4.text.toString() + inputOTP5.text.toString() + inputOTP6.text.toString())

            if (typedOTP.isNotEmpty()) {
                if (typedOTP.length == 6) {
                    val credential: PhoneAuthCredential = PhoneAuthProvider.getCredential(
                        OTP, typedOTP
                    )

                    commonMethods.showProgressDialog(this)
                    signInWithPhoneAuthCredential(credential)
                } else {
                    Toast.makeText(this, "Please Enter Correct OTP", Toast.LENGTH_SHORT).show()
                }
            } else {
                Toast.makeText(this, "Please Enter OTP", Toast.LENGTH_SHORT).show()
            }


        }
    }

    private fun resendOTPTvVisibility() {
        inputOTP1.setText("")
        inputOTP2.setText("")
        inputOTP3.setText("")
        inputOTP4.setText("")
        inputOTP5.setText("")
        inputOTP6.setText("")
        resendTV.visibility = View.INVISIBLE
        resendTV.isEnabled = false

        Handler(Looper.myLooper()!!).postDelayed(Runnable {
            resendTV.visibility = View.VISIBLE
            resendTV.isEnabled = true
        }, 60000)
    }

    private fun resendVerificationCode() {
        val options = PhoneAuthOptions.newBuilder(auth)
            .setPhoneNumber(phoneNumber)       // Phone number to verify
            .setTimeout(60L, TimeUnit.SECONDS) // Timeout and unit
            .setActivity(this)                 // Activity (for callback binding)
            .setCallbacks(callbacks)
            .setForceResendingToken(resendToken)// OnVerificationStateChangedCallbacks
            .build()
        PhoneAuthProvider.verifyPhoneNumber(options)
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
            commonMethods.showProgressDialog(this@OTPActivity)
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
            OTP = verificationId
            resendToken = token
        }
    }

    private fun signInWithPhoneAuthCredential(credential: PhoneAuthCredential) {
        auth.signInWithCredential(credential)
            .addOnCompleteListener(this) { task ->
                if (task.isSuccessful) {
                    // Sign in success, update UI with the signed-in user's information

                    Toast.makeText(this, "Authenticate Successfully", Toast.LENGTH_SHORT).show()
                    sendToMain()
                } else {
                    // Sign in failed, display a message and update the UI
                    Log.d("TAG", "signInWithPhoneAuthCredential: ${task.exception.toString()}")
                    if (task.exception is FirebaseAuthInvalidCredentialsException) {
                        // The verification code entered was invalid
                    }
                    // Update UI
                }

                commonMethods.showProgressDialog(this)
            }
    }

    private fun sendToMain() {

        val signin = Intent(applicationContext, Register::class.java)
        signin.putExtra(CommonKeys.FACEBOOK_ACCOUNT_KIT_PHONE_NUMBER_KEY, mobileNumber)
        signin.putExtra(CommonKeys.FACEBOOK_ACCOUNT_KIT_PHONE_NUMBER_COUNTRY_CODE_KEY, countryCode)
        signin.putExtra(CommonKeys.FACEBOOK_ACCOUNT_KIT_PHONE_NUMBER_COUNTRY_Name_CODE_KEY, countryNameCode)
        startActivity(signin)
        overridePendingTransition(R.anim.ub__slide_in_right, R.anim.ub__slide_out_left)
        finish()
    }

    private fun addTextChangeListener() {
        inputOTP1.addTextChangedListener(EditTextWatcher(inputOTP1))
        inputOTP2.addTextChangedListener(EditTextWatcher(inputOTP2))
        inputOTP3.addTextChangedListener(EditTextWatcher(inputOTP3))
        inputOTP4.addTextChangedListener(EditTextWatcher(inputOTP4))
        inputOTP5.addTextChangedListener(EditTextWatcher(inputOTP5))
        inputOTP6.addTextChangedListener(EditTextWatcher(inputOTP6))
    }

    private fun init() {
        auth = FirebaseAuth.getInstance()
        tvResendOTPLabel.visibility = View.VISIBLE
        runCountdownTimer()
        verifyBtn = findViewById(R.id.otp_verify)
        resendTV = findViewById(R.id.tv_resend_button)
        inputOTP1 = findViewById(R.id.one)
        inputOTP2 = findViewById(R.id.two)
        inputOTP3 = findViewById(R.id.three)
        inputOTP4 = findViewById(R.id.four)
        inputOTP5 = findViewById(R.id.five)
        inputOTP6 = findViewById(R.id.six)
    }


    inner class EditTextWatcher(private val view: View) : TextWatcher {
        override fun beforeTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {

        }

        override fun onTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {

        }

        override fun afterTextChanged(p0: Editable?) {

            val text = p0.toString()
            when (view.id) {
                R.id.one -> if (text.length == 1) inputOTP2.requestFocus()
                R.id.two -> if (text.length == 1) inputOTP3.requestFocus() else if (text.isEmpty()) inputOTP1.requestFocus()
                R.id.three -> if (text.length == 1) inputOTP4.requestFocus() else if (text.isEmpty()) inputOTP2.requestFocus()
                R.id.four -> if (text.length == 1) inputOTP5.requestFocus() else if (text.isEmpty()) inputOTP3.requestFocus()
                R.id.five -> if (text.length == 1) inputOTP6.requestFocus() else if (text.isEmpty()) inputOTP4.requestFocus()
                R.id.six -> if (text.isEmpty()) inputOTP5.requestFocus()

            }
        }

    }

    override fun onBackPressed() {
        //if (isPhoneNumberLayoutIsVisible) {
        super.onBackPressed()
        //} else {
        //showPhoneNumberField()
        // }
    }
    fun runCountdownTimer() {
        tvResendOTP.visibility = View.GONE
        tvResendOTPCountdown.visibility = View.VISIBLE
        tvResendOTPLabel.text = resources.getString(R.string.send_OTP_again_in)
        if (resentCountdownTimer != null) {
            resentCountdownTimer!!.cancel()
        }
        resentCountdownTimer = object : CountDownTimer(resendOTPWaitingSecond, 1000) {

            override fun onTick(millisUntilFinished: Long) {
                tvResendOTPCountdown.text = (millisUntilFinished / 1000).toString()
            }

            override fun onFinish() {
                tvResendOTPCountdown.visibility = View.GONE
                tvResendOTPLabel.text = resources.getString(R.string.resend_otp)
                tvResendOTP.visibility = View.VISIBLE
            }
        }.start()
    }
}