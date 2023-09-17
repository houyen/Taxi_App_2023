package com.seentechs.newtaxiusers.appcommon.pushnotification

/**
 * @author Seen Technologies
 * 
 * @package com.seentechs.newtaxiusers
 * @subpackage pushnotification
 * @category Firebase Config
 */
/* ************************************************************
    Firebase config file
    *************************************************************** */
object Config {

    // global topic to receive app wide push notifications
    val TOPIC_GLOBAL = "global"

    // broadcast receiver intent filters
    val REGISTRATION_COMPLETE = "registrationComplete"
    val PUSH_NOTIFICATION = "pushNotification"
    val NETWORK_CHANGES = "networkChanges"

    // id to handle the notification in the notification tray
    val NOTIFICATION_ID = 100
    val NOTIFICATION_ID_BIG_IMAGE = 101

    val SHARED_PREF = "ah_firebase"
}
