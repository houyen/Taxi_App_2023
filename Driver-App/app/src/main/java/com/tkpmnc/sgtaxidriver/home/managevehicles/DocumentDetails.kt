package com.tkpmnc.sgtaxidriver.home.managevehicles

import android.os.Bundle
import android.util.Log
import android.widget.TextView
import butterknife.BindView
import butterknife.ButterKnife
import butterknife.OnClick
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.home.datamodel.DocumentsModel
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.common.util.CommonKeys
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import com.tkpmnc.sgtaxidriver.common.views.CommonActivity
import javax.inject.Inject


class DocumentDetails : CommonActivity() {
    @OnClick(R.id.ivBack)
    fun onBack() {
        onBackPressed()
    }

    @BindView(R.id.tvTitle)
    lateinit var tvTitle: TextView

    @Inject
    lateinit var commonMethods: CommonMethods

    var documentDetails = ArrayList<DocumentsModel>()
    var documentPosition: Int? = null


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_document_details)
        ButterKnife.bind(this)
        AppController.getAppComponent().inject(this)
        tvTitle = findViewById(R.id.tvTitle)
        getIntentValues()
    }

    private fun getIntentValues() {

        if (intent.extras != null) {
            documentDetails = intent.getSerializableExtra(CommonKeys.Intents.DocumentDetailsIntent) as ArrayList<DocumentsModel>
            setHeader(getString(R.string.manage_documents))
        }

    }


    internal fun getAppCompatActivity(): CommonActivity {
        return this
    }


    fun setHeader(title: String) {
        try {
            Log.i("MNG_DOC", "setHeader: Doc title=$title")
            Log.i("MNG_DOC", "setHeader: Doc tvTitle is null=${(false)}")
            tvTitle.text = title
        } catch (e: Exception) {
            Log.i("MNG_DOC", "setHeader: Error=${e.localizedMessage}")
        }
    }


}
