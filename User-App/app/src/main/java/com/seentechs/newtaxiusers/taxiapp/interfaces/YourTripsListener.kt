package com.seentechs.newtaxiusers.taxiapp.interfaces

/**
 * @package com.seentechs.newtaxiuserseatsdriver
 * @subpackage interfaces
 * @category YourTripsListener
 * @author Seen Technologies
 * 
 */

import android.content.res.Resources

import com.seentechs.newtaxiusers.taxiapp.sidebar.trips.YourTrips


/*****************************************************************
 * YourTripsListener
 */

interface YourTripsListener {

    val res: Resources

    val instance: YourTrips
}
