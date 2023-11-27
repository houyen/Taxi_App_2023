package com.tkpmnc.sgtaxiuser.taxiapp.interfaces

/**
 * @package com.tkpmnc.sgtaxiusereatsdriver
 * @subpackage interfaces
 * @category YourTripsListener
 * @author Seen Technologies
 * 
 */

import android.content.res.Resources

import com.tkpmnc.sgtaxiuser.taxiapp.sidebar.trips.YourTrips


/*****************************************************************
 * YourTripsListener
 */

interface YourTripsListener {

    val res: Resources

    val instance: YourTrips
}
