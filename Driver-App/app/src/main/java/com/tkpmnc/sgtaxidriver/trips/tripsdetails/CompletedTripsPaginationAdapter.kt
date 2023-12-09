package com.tkpmnc.sgtaxidriver.trips.tripsdetails


import android.content.Context
import android.text.TextUtils
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.*
import androidx.cardview.widget.CardView
import androidx.recyclerview.widget.RecyclerView
import com.squareup.picasso.Picasso
import com.tkpmnc.sgtaxidriver.R
import com.tkpmnc.sgtaxidriver.common.configs.SessionManager
import com.tkpmnc.sgtaxidriver.home.interfaces.PaginationAdapterCallback
import com.tkpmnc.sgtaxidriver.common.network.AppController
import com.tkpmnc.sgtaxidriver.common.util.CommonKeys
import java.util.*
import javax.inject.Inject

class CompletedTripsPaginationAdapter internal constructor(private val context: Context, private val mCallback: PaginationAdapterCallback) : RecyclerView.Adapter<RecyclerView.ViewHolder>() {

    @Inject
    lateinit var sessionManager: SessionManager

    private val tripStatusModels: ArrayList<TripListModelArrayList>?
    private var isLoadingAdded = false
    private var retryPageLoad = false
    private var onItemRatingClickListener: onItemRatingClickListner? = null

    private var errorMsg: String? = null

    val isEmpty: Boolean
        get() = itemCount == 0


    internal fun setOnItemRatingClickListner(onItemRatingClickListner: onItemRatingClickListner) {
        this.onItemRatingClickListener = onItemRatingClickListner
    }

    interface onItemRatingClickListner {
        fun setRatingClick(position: Int, tripStatusModel: TripListModelArrayList)
    }

    init {
        tripStatusModels = ArrayList()
        AppController.getAppComponent().inject(this)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): RecyclerView.ViewHolder {
        var viewHolder: RecyclerView.ViewHolder? = null
        val inflater = LayoutInflater.from(parent.context)

        when (viewType) {
            ITEM -> {
                val viewItem = inflater.inflate(R.layout.app_trips_item_layout, parent, false)
                viewHolder = PastTripsViewHolder(viewItem)
            }
            LOADING -> {
                val viewLoading = inflater.inflate(R.layout.item_progress, parent, false)
                viewHolder = LoadingViewHolder(viewLoading)
            }
        }
        return viewHolder!!
    }

    override fun onBindViewHolder(holder: RecyclerView.ViewHolder, position: Int) {
        val tripStatusModel = tripStatusModels!![position] // Past Detail

        when (getItemViewType(position)) {
            ITEM -> {
                val pastTripsViewHolder = holder as PastTripsViewHolder
                val currencysymbol = sessionManager.currencySymbol

                pastTripsViewHolder.tv_country.text = context.resources.getString(R.string.trip_id) + tripStatusModel?.tripId!!
                pastTripsViewHolder.carname.text = tripStatusModel?.carType

                //pastTripsViewHolder.btnrate.setVisibility(View.GONE);

                if (tripStatusModel?.status == CommonKeys.TripStatus.Rating) {
                    //pastTripsViewHolder.btnrate.setVisibility(View.VISIBLE);
                    pastTripsViewHolder.status.text = context.getString(R.string.Rating)
                } else if (tripStatusModel?.status == CommonKeys.TripStatus.Cancelled) {
                    pastTripsViewHolder.status.text = context.getString(R.string.Cancelled)
                } else if (tripStatusModel?.status == CommonKeys.TripStatus.Completed) {
                    pastTripsViewHolder.status.text = context.getString(R.string.completed)
                } else if (tripStatusModel?.status == CommonKeys.TripStatus.Payment) {
                    pastTripsViewHolder.status.text = context.getString(R.string.payment)
                } else if (tripStatusModel?.status == CommonKeys.TripStatus.Begin_Trip) {
                    pastTripsViewHolder.status.text = context.getString(R.string.begin_trip)
                } else if (tripStatusModel?.status == CommonKeys.TripStatus.End_Trip) {
                    pastTripsViewHolder.status.text = context.getString(R.string.end_trip)
                } else if (tripStatusModel?.status == CommonKeys.TripStatus.Scheduled) {
                    pastTripsViewHolder.status.text = context.getString(R.string.scheduled)
                } else {
                    pastTripsViewHolder.status.text = tripStatusModel?.carType
                }
                pastTripsViewHolder.amountcard.text = /*sessionManager.currencySymbol+*/tripStatusModel?.driverEarnings



                if (TextUtils.isEmpty(tripStatusModel?.mapImage)) {
                    pastTripsViewHolder.mapView?.visibility =View.VISIBLE
                    if (context.resources.getString(R.string.layout_direction).equals("1")) {
                        pastTripsViewHolder.mapView?.rotationY = 180f
                    }
                    pastTripsViewHolder.tv_pickLocation.text=tripStatusModel?.pickup
                    pastTripsViewHolder.tv_dropLocation.text=tripStatusModel?.drop
                    pastTripsViewHolder.imageLayout?.visibility =View.GONE

                } else {
                    pastTripsViewHolder.imageLayout?.visibility=View.VISIBLE
                    pastTripsViewHolder.view_line?.visibility = View.GONE
                    pastTripsViewHolder.mapView?.visibility =View.INVISIBLE
                    Picasso.get().load(tripStatusModel?.mapImage)
                            .into(pastTripsViewHolder.imageView)
                }
               }

            LOADING -> {
                val loadingVH = holder as LoadingViewHolder
                if (retryPageLoad) {
                    loadingVH.mErrorLayout.visibility = View.VISIBLE
                    loadingVH.mProgressBar.visibility = View.GONE
                    loadingVH.mErrorTxt.text = if (errorMsg != null) errorMsg else context.getString(R.string.error_msg_unknown)
                } else {
                    loadingVH.mErrorLayout.visibility = View.GONE
                    loadingVH.mProgressBar.visibility = View.VISIBLE
                }
            }
        }
    }

    override fun getItemCount(): Int {
        return tripStatusModels?.size ?: 0
    }

    override fun getItemViewType(position: Int): Int {
        return if (position == tripStatusModels!!.size - 1 && isLoadingAdded) LOADING else ITEM
    }

   
    private fun getItem(position: Int): TripListModelArrayList? {
        return tripStatusModels!![position]
    }


    companion object {
        // View Types
        private val ITEM = 0
        private val LOADING = 1
    }
}