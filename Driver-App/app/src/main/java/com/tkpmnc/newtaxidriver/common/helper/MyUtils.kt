package com.tkpmnc.newtaxidriver.common.helper

/**
 * helper
 * @subpackage helper
 * @category MyUtils
 *  
 *
 */

import android.content.Context

/*   *******************************************************************************

                                 convert size type convertion

     ******************************************************************************** */

object MyUtils {

    fun dip2px(context: Context, dipValue: Float): Int {
        val scale = context.resources.displayMetrics.density
        return (dipValue * scale + 0.5f).toInt()
    }

    fun px2dip(context: Context, pxValue: Float): Int {
        val scale = context.resources.displayMetrics.density
        return (pxValue / scale + 0.5f).toInt()
    }

    fun sp2px(context: Context, spValue: Float): Int {
        val fontScale = context.resources.displayMetrics.scaledDensity
        return (spValue * fontScale + 0.5f).toInt()
    }

}
