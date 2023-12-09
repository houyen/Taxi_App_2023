package com.tkpmnc.sgtaxidriver.home.interfaces

/**
 * @package com.tkpmnc.sgtaxidriver
 * @subpackage interfaces
 * @category YourTripsListener
 * 
 *
 */

import android.content.res.Resources

import com.tkpmnc.sgtaxidriver.trips.tripsdetails.YourTrips


/*****************************************************************
 * YourTripsListener
 */

interface YourTripsListener {

    val res: Resources

    val instance: YourTrips
}
