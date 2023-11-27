package com.tkpmnc.sgtaxiuser.appcommon.drawpolyline

/**
 * @package com.tkpmnc.sgtaxiuserdriver
 * @subpackage map.drawpolyline
 * @category PolylineOptionsInterface
 * @author Seen Technologies
 * 
 */

import com.google.android.gms.maps.model.LatLng
import com.google.android.gms.maps.model.PolylineOptions
import com.tkpmnc.sgtaxiuser.taxiapp.datamodels.StepsClass
import java.util.*

interface PolylineOptionsInterface {
    fun getPolylineOptions(output: PolylineOptions, points: ArrayList<LatLng>, distance: String, overviewPolyline: String, arrivalTime: String, stepPoints: ArrayList<StepsClass>, totalDuration : Int)
}
