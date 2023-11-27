package com.tkpmnc.sgtaxiuser.appcommon.custompalette

/**
 * @package com.tkpmnc.sgtaxiuser
 * @subpackage custompalette
 * @category CustomTypefaceSpan
 * @author Seen Technologies
 *
 */

import android.annotation.SuppressLint
import android.graphics.Paint
import android.graphics.Typeface
import android.text.TextPaint
import android.text.style.TypefaceSpan

/* ************************************************************
                CustomTypefaceSpan
Used for spannable string in main activity
*************************************************************** */
@SuppressLint("ParcelCreator")
class CustomTypefaceSpan
/**
 * Typefacespan
 */
(family: String, private val newType: Typeface) : TypefaceSpan(family) {

    /**
     * Apply Typeface
     */
    private fun applyCustomTypeFace(paint: Paint, tf: Typeface) {
        val oldStyle: Int
        val old = paint.typeface
        if (old == null) {
            oldStyle = 0
        } else {
            oldStyle = old.style
        }

        val fake = oldStyle and tf.style.inv()
        if (fake and Typeface.BOLD != 0) {
            paint.isFakeBoldText = true
        }

        if (fake and Typeface.ITALIC != 0) {
            paint.textSkewX = -0.25f
        }

        paint.typeface = tf // Set Type space
    }

    /**
     * Draw Textpaint
     */
    override fun updateDrawState(ds: TextPaint) {
        applyCustomTypeFace(ds, newType)
    }

    /**
     * Measure states of textpaint
     */
    override fun updateMeasureState(paint: TextPaint) {
        applyCustomTypeFace(paint, newType)
    }
}
