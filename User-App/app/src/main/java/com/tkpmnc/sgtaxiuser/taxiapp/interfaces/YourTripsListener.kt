package com.tkpmnc.sgtaxiusers.taxiapp.interfaces

/**
 * @package com.tkpmnc.sgtaxiuserseatsdriver
 * @subpackage interfaces
 * @category YourTripsListener
 * @author Seen Technologies
 * 
 */

import android.content.res.Resources

import com.tkpmnc.sgtaxiusers.taxiapp.sidebar.trips.YourTrips


/*****************************************************************
 * YourTripsListener
 */

interface YourTripsListener {

    val res: Resources

    val instance: YourTrips
}
