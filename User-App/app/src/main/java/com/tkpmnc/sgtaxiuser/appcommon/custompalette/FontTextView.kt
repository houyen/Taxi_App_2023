package com.tkpmnc.sgtaxiusers.appcommon.custompalette

/**
 * @package com.tkpmnc.sgtaxiusers
 * @subpackage custompalette
 * @category FontTextView
 * @author Seen Technologies
 *
 */

import android.content.Context
import android.util.AttributeSet
import android.widget.TextView

/* ************************************************************
                FontTextView
Used for custom textview when you want use custom fonts in textview
*************************************************************** */
class FontTextView : TextView {

    constructor(context: Context) : super(context) {

        CustomFontUtils.applyCustomFont(this, context, null)
    }

    constructor(context: Context, attrs: AttributeSet) : super(context, attrs) {

        CustomFontUtils.applyCustomFont(this, context, attrs)
    }

    constructor(context: Context, attrs: AttributeSet, defStyle: Int) : super(context, attrs, defStyle) {

        CustomFontUtils.applyCustomFont(this, context, attrs)
    }


}