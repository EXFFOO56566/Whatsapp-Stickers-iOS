//
//  AdmobManager.swift
//  WhtasWeb
//
//  Created by CATALINA on 11/09/20.
//  Copyright © 2020 MehulKathiriya. All rights reserved.
//

import Foundation
import GoogleMobileAds

class AdmobManager : NSObject, GADFullScreenContentDelegate {
    
    static let shared = AdmobManager()
    
    var interstitialAd: GADInterstitialAd?
    var vc : UIViewController?
    var strType :  String = ""
    
    var total : Int = 0
    var kUserDefault = UserDefaults.standard
    
    func requestAds() {
        let request = GADRequest()
        GADInterstitialAd.load(withAdUnitID:FullAD,
            request: request,
            completionHandler: { [self] ad, error in
                if let error = error {
                  //print("Failed to load interstitial ad with error: \(error.localizedDescription)")
                  return
                }
                self.interstitialAd = ad
                self.interstitialAd?.fullScreenContentDelegate = self
            }
        )
    }
    
    func showAds(vw : UIViewController,str: String)  {
        
        vc = vw
        strType = str
        
        if kUserDefault.object(forKey: "total") == nil {
            total = 0
        } else {
            total = Int(kUserDefault.object(forKey: "total") as! String)!
        }
        
        if(total == 0) {
            if interstitialAd != nil {
                total = total + 1
                kUserDefault.set("\(total)", forKey: "total")
                kUserDefault.synchronize()
                interstitialAd?.present(fromRootViewController: vw)
            } else {
                common()
            }
        } else {
            if(total >= Int(AD_GAP)! ) {
                total = 0
            } else {
                total = total + 1
            }
            kUserDefault.set("\(total)", forKey: "total")
            kUserDefault.synchronize()
            common()
        }
        
    }
    
    /// Tells the delegate that the ad failed to present full screen content.
    func ad(_ ad: GADFullScreenPresentingAd, didFailToPresentFullScreenContentWithError error: Error) {
        common()
        //print("Ad did fail to present full screen content.")
    }

    /// Tells the delegate that the ad presented full screen content.
    func adDidPresentFullScreenContent(_ ad: GADFullScreenPresentingAd) {
       //print("Ad did present full screen content.")
    }

    /// Tells the delegate that the ad dismissed full screen content.
    func adDidDismissFullScreenContent(_ ad: GADFullScreenPresentingAd) {
        common()
        //print("Ad did dismiss full screen content.")
    }
    
//    func interstitialDidFail(toPresentScreen ad: GADInterstitial) {
//       common()
//    }
//
//    func interstitialWillDismissScreen(_ ad: GADInterstitial) {
//        common()
//    }
    
    func common() {
        if strType == "store" || strType == "create" || strType == "my"  {
            let v = vc as! MainViewController
            v.sendToAdmob(str: strType)
        } else if strType == "pack" || strType == "sub" {
            let v = vc as! ViewController
            v.sendToAdmob(str: strType)
        } else if strType == "pack_sub" {
            let v = vc as! AllSubViewController
            v.sendToAdmob(str: strType)
        } else if strType == "next" {
            let v = vc as! CreateStickerViewController
            v.sendToAdmob(str: strType)
        } else if strType == "pack_create" {
            let v = vc as! CreateSticker2ViewController
            v.sendToAdmob(str: strType)
        } else if strType == "edit" || strType == "pack_my" {
            let v = vc as! MyStickerViewController
            v.sendToAdmob(str: strType)
        } else if strType == "pack_edit" {
            let v = vc as! EditViewController
            v.sendToAdmob(str: strType)
        }
    }
  
}
	
