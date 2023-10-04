package com.seentechs.newtaxidriver.home.interfaces

/**
 *  newtaxidriver
 * @subpackage interfaces
 * @category YourTripsListener
 *  
 *
 */

import android.content.res.Resources

import com.seentechs.newtaxidriver.trips.tripsdetails.YourTrips


/*****************************************************************
 * YourTripsListener
 */

interface YourTripsListener {

    val res: Resources

    val instance: YourTrips
}
