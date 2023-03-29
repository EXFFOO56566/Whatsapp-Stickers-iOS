//
//  CustomPackViewController.swift
//  Sticker
//
//  Created by Mehul on 19/06/19.
//  Copyright © 2019 Mehul. All rights reserved.
//

import UIKit
import Alamofire
import MBProgressHUD
import SDWebImage
import GoogleMobileAds
import SDWebImageWebPCoder

class CustomPackViewController: UIViewController, UICollectionViewDataSource, UICollectionViewDelegate, UICollectionViewDelegateFlowLayout {

    @IBOutlet weak var imgTray: UIImageView!
    @IBOutlet weak var lblTitle: UILabel!
    @IBOutlet weak var lblTotal: UILabel!
    @IBOutlet weak var btnDownload: UIButton!
    @IBOutlet weak var stickersCollectionView: UICollectionView!
    @IBOutlet weak var viewBanner: GADBannerView!
    
    
    private var stickerPacks: [StickerPack] = []
    var stickerPack: StickerPack!
    var arySticker : NSMutableArray = []
    var dicSticker : NSMutableDictionary = [:]
    var dicMain : NSMutableDictionary = [:]
    var dicFinal : Dictionary<String,Any> = [:]
    var strFrom : String = ""
    var iApp : String = ""
    var aApp : String = ""
    
    override func viewDidLoad() {
        super.viewDidLoad()
        stickersCollectionView.register(StickerCell.self, forCellWithReuseIdentifier: "StickerCell")
        btnDownload.layer.cornerRadius = 3.0
        btnDownload.layer.masksToBounds = true
    }
    
    override func viewWillAppear(_ animated: Bool) {
        
        lblTitle.text = dicSticker["pack_name"] as? String
        
        let activityIndicator = UIActivityIndicatorView.init(style: UIActivityIndicatorView.Style.gray)
        activityIndicator.center = imgTray.center
        activityIndicator.hidesWhenStopped = true
        activityIndicator.startAnimating()
        imgTray.addSubview(activityIndicator)
        imgTray.sd_setImage(with: URL(string: dicSticker["tray_image"] as! String), completed: { (image: UIImage?, error: Error?, cacheType: SDImageCacheType, imageURL: URL?) in
            activityIndicator.removeFromSuperview()
        })
        
        arySticker = (dicSticker["sticker"] as! NSArray).mutableCopy() as! NSMutableArray
        
        if isAnimatedExist() == true {
            self.lblTotal.text = "\(arySticker.count) Stickers (Animated)"
        } else {
            self.lblTotal.text = "\(arySticker.count) Stickers"
        }
        
        verifyURL(urlPath: I_App, completion: { (isOK) in
            if isOK {
                self.iApp = I_App
            } else {
                self.iApp = ""
            }
        })
        verifyURL(urlPath: A_App, completion: { (isOK) in
            if isOK {
                self.aApp = A_App
            } else {
                self.aApp = ""
            }
        })
        
        setLayout()
        loadBannerAd()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    // MARK: Collection view method
    func collectionView(_ collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, sizeForItemAt indexPath: IndexPath) -> CGSize {
        let width = collectionView.bounds.width
        let cellWidth = (width - 30) / 4
        return CGSize(width: cellWidth, height: cellWidth)
    }
    
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        if (stickerPack != nil) {
            return stickerPack.stickers.count
        } else {
            return arySticker.count
        }
    }
    
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        
        let cell = collectionView.dequeueReusableCell(withReuseIdentifier: "PackCell", for: indexPath) as! PackCell
        
        cell.layer.borderWidth = 0.3
        cell.layer.borderColor = UIColor.lightGray.cgColor
        
        var dic : NSMutableDictionary = [:]
        dic = (arySticker.object(at: indexPath.row) as! NSDictionary).mutableCopy() as! NSMutableDictionary
        
        var strImage : String = ""
        if (dic["sticker_image"] as? String) != nil {
          //NOT NULL
            strImage = (dic["sticker_image"] as! String).addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed)!
        } else {
           //NULL
            strImage = ""
        }
        
        cell.imgSticker.sd_setImage(with: URL(string: strImage), placeholderImage: UIImage(named: "default_sticker"))

        return cell
    }
    
    func collectionView(_ collectionView: UICollectionView, didSelectItemAt indexPath: IndexPath) {
        let cell = collectionView.cellForItem(at: indexPath)
        
        var dic : NSMutableDictionary = [:]
        dic = (arySticker.object(at: indexPath.row) as! NSDictionary).mutableCopy() as! NSMutableDictionary
        
        showActionSheet(overCell: cell!, strUrl: dic["sticker_image"] as! String)
    }
 
    // MARK: Button Action
    @IBAction func btnBackClick(_ sender: Any) {
        if strFrom == "" {
            self.navigationController?.popViewController(animated: true)
        } else {
            let rootVC:MainViewController = self.storyboard?.instantiateViewController(withIdentifier: "MainViewController") as! MainViewController
            let nvc:UINavigationController = self.storyboard?.instantiateViewController(withIdentifier: "main") as! UINavigationController
            nvc.viewControllers = [rootVC]
            UIApplication.shared.keyWindow?.rootViewController = nvc
        }
    }
    
    @IBAction func btnDownloadClick(_ sender: Any) {
        let urlWhats = "whatsapp://"
        if let urlString = urlWhats.addingPercentEncoding(withAllowedCharacters: NSCharacterSet.urlQueryAllowed) {
            if let whatsappURL = URL(string: urlString) {
                if UIApplication.shared.canOpenURL(whatsappURL) {
                    self.makePack()
                } else {
                    showAlert(strMessage: "Whatsapp is not installed in your device.")
                }
            }
        }
    }
    
    // MARK: Method
    func makePack()  {
        
        MBProgressHUD.showAdded(to: self.view, animated: true)
        
        let aryStickerPack : NSMutableArray = []
        
        let aryBlank : NSMutableArray = []
        aryBlank.add("")
        aryBlank.add("")
        
        dicMain.setValue(I_App, forKey: "ios_app_store_link")
        dicMain.setValue(A_App, forKey: "android_play_store_link")
        
        let date = Date()
        let formatter = DateFormatter()
        formatter.dateFormat = "dd.MM.yyyy.hh.mm.ss"
        
        let dicStickerPack : NSMutableDictionary = [:]
        dicStickerPack.setValue(formatter.string(from: date), forKey: "identifier")
        dicStickerPack.setValue(lblTitle.text, forKey: "name")
        dicStickerPack.setValue("Loop Infosol", forKey: "publisher")
        dicStickerPack.setValue(dicSticker["tray_image"] as! String, forKey: "tray_image_file")
        dicStickerPack.setValue("", forKey: "publisher_website")
        dicStickerPack.setValue("", forKey: "privacy_policy_website")
        dicStickerPack.setValue("", forKey: "license_agreement_website")
        
        if isAnimatedExist() == true {
            dicStickerPack.setValue(true, forKey: "animated_sticker_pack")
        } else {
            dicStickerPack.setValue(false, forKey: "animated_sticker_pack")
        }
        
        
        let aryS : NSMutableArray = []
        
        for i in 0..<arySticker.count {
            var dic : NSMutableDictionary = [:]
            dic = (arySticker.object(at: i) as! NSDictionary).mutableCopy() as! NSMutableDictionary
            let dicSticker : NSMutableDictionary = [:]
            dicSticker.setValue(dic["sticker_image"] as! String, forKey: "image_file")
            dicSticker.setValue(aryBlank, forKey: "emojis")
            aryS.add(dicSticker)
        }
        
        dicStickerPack.setValue(aryS, forKey: "stickers")
        
        aryStickerPack.add(dicStickerPack)
        
        dicMain.setValue(aryStickerPack, forKey: "sticker_packs")
        
        if let theJSONData = try? JSONSerialization.data(
            withJSONObject: dicMain,
            options: []) {
            let theJSONText = String(data: theJSONData,
                                     encoding: .ascii)
            let data = theJSONText?.data(using: .utf8)!
            do {
                if let jsonArray = try JSONSerialization.jsonObject(with: data!, options : .allowFragments) as? Dictionary<String,Any>
                {
                    dicFinal = jsonArray
                    fetchStickerPacks()
                } else {
                    print("bad json")
                }
            } catch let error as NSError {
                print(error)
            }
        }
    }
    
    private func fetchStickerPacks() {
        StickerPackManager.fetchStickerPacks(fromJSON: dicFinal) { stickerPacks in
            self.stickerPacks = stickerPacks
            self.stickerPack = stickerPacks[0]
            
            if(self.stickerPack.stickers.count > 0) {
                MBProgressHUD.hide(for: self.view, animated: true)
                self.sendSticker()
            }
        }
    }
    
    func showActionSheet(overCell cell: UICollectionViewCell,strUrl: String) {
        
        let actionSheet: UIAlertController = UIAlertController(title: "\n\n\n\n\n\n", message: "", preferredStyle: .actionSheet)
        
        actionSheet.popoverPresentationController?.sourceView = cell.contentView
        actionSheet.popoverPresentationController?.permittedArrowDirections = UIPopoverArrowDirection()
        actionSheet.popoverPresentationController?.sourceRect = CGRect(x: cell.contentView.bounds.midX, y: cell.contentView.bounds.midY, width: 0, height: 0)
        
        
        actionSheet.addAction(UIAlertAction(title: "COPY TO CLIPBOARD", style: .default, handler: { action in
            do {
                let url = URL(string:strUrl)
                let imageData = try Data(contentsOf: url!)
                let ima = SDImageWebPCoder.shared.decodedImage(with: imageData, options: nil)!
                Interoperability.copyImageToPasteboard(image: ima)
            } catch {
                print("Unable to load data: \(error)")
            }
        }))
        actionSheet.addAction(UIAlertAction(title: "SHARE", style: .default, handler: { action in
            self.showShareSheet(imgUrl: strUrl)
        }))
        actionSheet.addAction(UIAlertAction(title: "CANCEL", style: .cancel, handler: nil))
        
        do {
            let urlSticker = URL(string: strUrl)!
            let imageData = try Data(contentsOf: urlSticker)
            let ima = SDImageWebPCoder.shared.decodedImage(with: imageData, options: nil)!
            actionSheet.addImageView(withImage: ima)
        } catch {
            print("Unable to load data: \(error)")
        }
        
        present(actionSheet, animated: true, completion: nil)
        
    }
    
    func showShareSheet(imgUrl: String) {
        
        let urlSticker = URL(string: imgUrl)!

        do {
            
            let imageData = try Data(contentsOf: urlSticker)
            let ima = SDImageWebPCoder.shared.decodedImage(with: imageData, options: nil)!
            
            let shareViewController: UIActivityViewController = UIActivityViewController(activityItems: [ima], applicationActivities: nil)
            shareViewController.popoverPresentationController?.sourceView = self.view
        shareViewController.popoverPresentationController?.permittedArrowDirections = UIPopoverArrowDirection()
            shareViewController.popoverPresentationController?.sourceRect = CGRect(x: self.view.bounds.midX, y: self.view.bounds.midY, width: 0, height: 0)
            present(shareViewController, animated: true, completion: nil)

        } catch {
            print("Unable to load data: \(error)")
        }
        
    }
    
    func sendSticker() {
        let loadingAlert: UIAlertController = UIAlertController(title: "Sending to WhatsApp", message: "\n\n", preferredStyle: .alert)
        loadingAlert.addSpinner()
        present(loadingAlert, animated: true, completion: nil)
        
        stickerPack.sendToWhatsApp { completed in
            loadingAlert.dismiss(animated: true, completion: nil)
        }
    }
    
    func showAlert(strMessage: String)  {
        let alert = UIAlertController(title: "MESSAGE", message: strMessage, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: "OK", style: UIAlertAction.Style.default, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    
    func verifyURL(urlPath: String, completion: @escaping (_ isOK: Bool)->()) {
        if let url = URL(string: urlPath) {
            var request = URLRequest(url: url)
            request.httpMethod = "HEAD"
            let task = URLSession.shared.dataTask(with: request, completionHandler: { (data, response, error) in
                if let httpResponse = response as? HTTPURLResponse, error == nil {
                    completion(httpResponse.statusCode == 200)
                } else {
                    completion(false)
                }
            })
            task.resume()
        } else {
            completion(false)
        }
    }
    
    func isAnimatedExist() -> Bool {
        
        var isAvail : Bool = false
        for i in 0 ..< self.arySticker.count {
            var dic : NSMutableDictionary = [:]
            dic = (self.arySticker[i] as! NSDictionary).mutableCopy() as! NSMutableDictionary
            if(dic["is_animated"] as! String == "YES") {
                isAvail = true
                break
            }
        }
        
        if isAvail {
            return true
        } else {
            return false
        }
        
    }
    
    // MARK: Admob Ads Method
    func setLayout() {
        if UIDevice.current.modelName == "iPhone 4" || UIDevice.current.modelName == "iPhone 4s" || UIDevice.current.modelName == "iPhone 5" || UIDevice.current.modelName == "iPhone 5c" || UIDevice.current.modelName == "iPhone 5s" || UIDevice.current.modelName == "iPhone 6" || UIDevice.current.modelName == "iPhone 6 Plus" || UIDevice.current.modelName == "iPhone 6s" || UIDevice.current.modelName == "iPhone 6s Plus" || UIDevice.current.modelName == "iPhone 7" || UIDevice.current.modelName == "iPhone 7 Plus" || UIDevice.current.modelName == "iPhone SE" || UIDevice.current.modelName == "iPhone 8" || UIDevice.current.modelName == "iPhone 8 Plus"{
            
        } else {
            stickersCollectionView.frame = CGRect(x: stickersCollectionView.frame.origin.x, y: stickersCollectionView.frame.origin.y, width: stickersCollectionView.frame.size.width, height: self.view.frame.size.height - 168 - 66 - 8)
            viewBanner.frame = CGRect(x: viewBanner.frame.origin.x, y: self.view.frame.size.height - 66, width: viewBanner.frame.size.width, height: viewBanner.frame.size.height)
        }
    }
    
    func loadBannerAd() {
        viewBanner.adUnitID = BannerAD
        viewBanner.rootViewController = self
        viewBanner.load(GADRequest())
    }
}
