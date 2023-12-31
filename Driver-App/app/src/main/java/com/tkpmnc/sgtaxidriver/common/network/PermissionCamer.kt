package com.tkpmnc.sgtaxidriver.common.network

/**
 * @package com.tkpmnc.sgtaxidriver.common.network
 * @subpackage network
 * @category PermissionCamer
 * 
 *
 */

import android.Manifest
import android.content.Context
import android.content.pm.PackageManager
import androidx.core.app.ActivityCompat


/* ************************************************************
Whole application to get the permission
*************************************************************** */

object PermissionCamer {

    /*
    *  Check permission
    */
    fun checkPermission(context: Context): Boolean {
        return ActivityCompat.checkSelfPermission(context, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(context, Manifest.permission.ACCESS_COARSE_LOCATION) == PackageManager.PERMISSION_GRANTED
    }


}
