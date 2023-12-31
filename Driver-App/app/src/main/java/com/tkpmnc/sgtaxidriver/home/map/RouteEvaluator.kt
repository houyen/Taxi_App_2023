package com.tkpmnc.sgtaxidriver.home.map

/**
 * @package com.tkpmnc.sgtaxidriver
 * @subpackage map
 * @category RouteEvaluator
 * 
 *
 */

import android.animation.TypeEvaluator

import com.google.android.gms.maps.model.LatLng

class RouteEvaluator : TypeEvaluator<LatLng> {
    override fun evaluate(t: Float, startPoint: LatLng, endPoint: LatLng): LatLng {
        val lat = startPoint.latitude + t * (endPoint.latitude - startPoint.latitude)
        val lng = startPoint.longitude + t * (endPoint.longitude - startPoint.longitude)
        return LatLng(lat, lng)
    }
}
