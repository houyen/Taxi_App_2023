package com.seentechs.newtaxiusers.taxiapp.interfaces

/**
 *  newtaxiuserseatsdriver
 * @subpackage interfaces
 * @category YourTripsListener
 *  
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
