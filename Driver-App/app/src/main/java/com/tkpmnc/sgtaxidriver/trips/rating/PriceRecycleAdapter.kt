package com.tkpmnc.sgtaxidriver.trips.rating

/**
 * @package com.tkpmnc.sgtaxidriver.trips.rating
 * @subpackage rating
 * @category CommentsRecycleAdapter
 * 
 *
 */

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.TextView
import androidx.appcompat.app.AlertDialog
import androidx.recyclerview.widget.RecyclerView
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.common.custompalette.FontCache
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.common.util.CommonMethods
import java.util.*
import javax.inject.Inject

/* ************************************************************
                CommentsRecycleAdapter
Its used to view the feedback comments with rider screen page function
*************************************************************** */
class PriceRecycleAdapter(private val context: Context, private val feedbackarraylist: ArrayList<ViewHolder>) : RecyclerView.Adapter<PriceRecycleAdapter.ViewHolder>() {
    @Inject

    lateinit var commonMethods: CommonMethods
    lateinit var dialog: AlertDialog

    private val Other_reason: String? = null

    init {

        AppController.getAppComponent().inject(this)
    }

    override fun onCreateViewHolder(viewGroup: ViewGroup, i: Int): PriceRecycleAdapter.ViewHolder {
        val view = LayoutInflater.from(viewGroup.context).inflate(R.layout.price_layout, viewGroup, false)


        return ViewHolder(view)
    }

    /*
   *  Get rider feedback list bind
   */
    override fun onBindViewHolder(viewHolder: PriceRecycleAdapter.ViewHolder, i: Int) {
        CommonMethods.DebuggableLogI("key", feedbackarraylist[i].key)
        CommonMethods.DebuggableLogI("value", feedbackarraylist[i].value)

        viewHolder.faretxt.text = feedbackarraylist[i].key
        viewHolder.fareAmt.text = feedbackarraylist[i].value!!.replace("\"", "")
        viewHolder.fareinfo.visibility = View.GONE
        viewHolder.fareAmt.visibility = View.VISIBLE
        if (feedbackarraylist[i].key == "Base fare") {
            viewHolder.isbase.visibility = View.GONE
        }


        if (!feedbackarraylist[i].fareComments.equals("", ignoreCase = true)) {
            viewHolder.fareinfo.visibility = View.VISIBLE
        } else {
            viewHolder.fareinfo.visibility = View.GONE
        }

        if (feedbackarraylist[i].bar == "1") {

            viewHolder.basrfarelayout.background = context.resources.getDrawable(R.drawable.d_topboarder)

            println("Key check feedback : " + feedbackarraylist[i].key!!)

        } else {
            viewHolder.basrfarelayout.setBackgroundColor(context.resources.getColor(R.color.white))
        }
        if (feedbackarraylist[i].colour == "black") {
            viewHolder.fareAmt.typeface = FontCache.getTypeface(context.resources.getString(R.string.fonts_UBERMedium), context)
            viewHolder.faretxt.typeface = FontCache.getTypeface(context.resources.getString(R.string.fonts_UBERMedium), context)
            viewHolder.fareAmt.setTextColor(context.resources.getColor(R.color.newtaxi_app_black_dark))
            viewHolder.faretxt.setTextColor(context.resources.getColor(R.color.newtaxi_app_black_dark))
            viewHolder.fareAmt.setTextSize(16F)
            viewHolder.faretxt.setTextSize(16F)
        }
        if (feedbackarraylist[i].colour == "green" || feedbackarraylist[i].colour == "navy") {
            viewHolder.fareAmt.typeface = FontCache.getTypeface(context.resources.getString(R.string.fonts_UBERMedium), context)
            viewHolder.faretxt.typeface = FontCache.getTypeface(context.resources.getString(R.string.fonts_UBERMedium), context)
            viewHolder.fareAmt.setTextColor(context.resources.getColor(R.color.newtaxi_app_navy))
            viewHolder.faretxt.setTextColor(context.resources.getColor(R.color.newtaxi_app_navy))
            viewHolder.fareAmt.setTextSize(16F)
            viewHolder.faretxt.setTextSize(16F)
        }
        viewHolder.fareinfo.setOnClickListener {
            dialog = commonMethods.getAlertDialog(context)
            commonMethods.showMessage(context, dialog, feedbackarraylist[i].fareComments)
        }

    }

    override fun getItemCount(): Int {
        return feedbackarraylist.size
    }

    inner class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {

        internal val faretxt: TextView
        internal val fareAmt: TextView
        internal val isbase: TextView
        internal val rltprice: LinearLayout
        internal val basrfarelayout: LinearLayout
        internal val fareinfo: ImageView

        init {

            faretxt = view.findViewById<View>(R.id.faretxt) as TextView
            fareinfo = view.findViewById<View>(R.id.fareinfo) as ImageView

            fareAmt = view.findViewById<View>(R.id.fareAmt) as TextView
            isbase = view.findViewById<View>(R.id.baseview) as TextView
            rltprice = view.findViewById<View>(R.id.rltprice) as LinearLayout
            basrfarelayout = view.findViewById<View>(R.id.basrfarelayout) as LinearLayout

        }
    }


}
