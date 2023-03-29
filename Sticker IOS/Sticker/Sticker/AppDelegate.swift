//
//  AppDelegate.swift
//  Sticker
//
//  Created by VIRAL  on 08/05/20.
//  Copyright © 2020 MehulKathiriya. All rights reserved.
//

import UIKit
import GoogleMobileAds
import OneSignal
import AppTrackingTransparency
import SDWebImageWebPCoder

@UIApplicationMain
class AppDelegate: UIResponder, UIApplicationDelegate {

    var window: UIWindow?
    
    func application(_ application: UIApplication, didFinishLaunchingWithOptions launchOptions: [UIApplication.LaunchOptionsKey: Any]?) -> Bool {
        // Override point for customization after application launch.
        
        // It will reset ad counter to zero.
        if (UserDefaults.standard.object(forKey: "total") != nil) {
            let defaults = UserDefaults.standard
            defaults.removeObject(forKey: "total")
            defaults.synchronize()
        }
        
        let WebPCoder = SDImageWebPCoder.shared
        SDImageCodersManager.shared.addCoder(WebPCoder)
        
        GADMobileAds.sharedInstance().start(completionHandler: nil)
        
        AdmobManager.shared.requestAds()
        
        //START OneSignal initialization code
        OneSignal.initWithLaunchOptions(launchOptions)
        OneSignal.setAppId(ONESIGNAL_APP_ID)
        OneSignal.promptForPushNotifications(userResponse: { accepted in
            print("User accepted notifications: \(accepted)")
            DispatchQueue.main.asyncAfter(deadline: .now() + 1) {
                if #available(iOS 14, *) {
                    ATTrackingManager.requestTrackingAuthorization { (status) in
                        //print("IDFA STATUS: \(status.rawValue)")
                    }
                }
            }
        })
        //END OneSignal initializataion code
        
        
        
        return true
    }

}

