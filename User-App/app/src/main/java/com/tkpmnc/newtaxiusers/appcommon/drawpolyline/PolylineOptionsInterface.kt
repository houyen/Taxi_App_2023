package com.tkpmnc.newtaxiusers.appcommon.drawpolyline

/**
 *  newtaxiusersdriver
 * @subpackage map.drawpolyline
 * @category PolylineOptionsInterface
 *  
 * 
 */

import com.google.android.gms.maps.model.LatLng
import com.google.android.gms.maps.model.PolylineOptions
import com.tkpmnc.newtaxiusers.taxiapp.datamodels.StepsClass
import java.util.*

interface PolylineOptionsInterface {
    fun getPolylineOptions(output: PolylineOptions, points: ArrayList<LatLng>, distance: String, overviewPolyline: String, arrivalTime: String, stepPoints: ArrayList<StepsClass>, totalDuration : Int)
}
