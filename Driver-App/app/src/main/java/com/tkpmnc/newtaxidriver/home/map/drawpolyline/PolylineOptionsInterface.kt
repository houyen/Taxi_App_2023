package com.tkpmnc.newtaxidriver.home.map.drawpolyline

/**
 *  newtaxidriver
 * @subpackage map.drawpolyline
 * @category PolylineOptionsInterface
 *  
 *
 */

import com.google.android.gms.maps.model.LatLng
import com.google.android.gms.maps.model.PolylineOptions
import com.tkpmnc.newtaxidriver.home.datamodel.StepsClass
import java.util.*

interface PolylineOptionsInterface {
    fun getPolylineOptions(output: PolylineOptions, points: ArrayList<LatLng>, distance: String, overviewPolyline: String, stepPoints: ArrayList<StepsClass>, totalDuration : Int)
}
