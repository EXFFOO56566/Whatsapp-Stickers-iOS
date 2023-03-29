//
//  PackViewController.swift
//  Sticker
//
//  Created by Mehul on 04/03/19.
//  Copyright © 2019 Mehul. All rights reserved.
//

import UIKit
import Alamofire
import MBProgressHUD
import SDWebImage
import GoogleMobileAds
import SDWebImageWebPCoder

class PackViewController: UIViewController, UICollectionViewDataSource, UICollectionViewDelegate, UICollectionViewDelegateFlowLayout {

    var isAnimated : String = ""
    var strTitle : String = ""
    var catID : String = ""
    var subCatID : String = ""
    var strTrayUrl : String = ""
    var aryList : NSMutableArray = []
    private var stickerPacks: [StickerPack] = []
    var stickerPack: StickerPack!
    var dicMain : NSMutableDictionary = [:]
    var dicFinal : Dictionary<String,Any> = [:]
    var iApp : String = ""
    var aApp : String = ""
    
    @IBOutlet weak var btnDownload: UIButton!
    @IBOutlet weak var lblTitle: UILabel!
    @IBOutlet private weak var stickersCollectionView: UICollectionView!
    @IBOutlet weak var lblTotal: UILabel!
    @IBOutlet weak var imgTray: UIImageView!
    @IBOutlet weak var lblEx: UILabel!
    @IBOutlet weak var viewBanner: GADBannerView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
    }

    override func viewWillAppear(_ animated: Bool) {
        
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
        getData()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    // MARK: Retrive data from server
    func getData() {
    
        lblTitle.text = strTitle
        
        /// Register StickerCell
        stickersCollectionView.register(StickerCell.self, forCellWithReuseIdentifier: "StickerCell")
        btnDownload.layer.cornerRadius = 3.0
        btnDownload.layer.masksToBounds = true
        
        let activityIndicator = UIActivityIndicatorView.init(style: UIActivityIndicatorView.Style.gray)
        activityIndicator.center = imgTray.center
        activityIndicator.hidesWhenStopped = true
        activityIndicator.startAnimating()
        imgTray.addSubview(activityIndicator)
        imgTray.sd_setImage(with: URL(string: strTrayUrl), completed: { (image: UIImage?, error: Error?, cacheType: SDImageCacheType, imageURL: URL?) in
            activityIndicator.removeFromSuperview()
        })
        
        let param : Parameters = [
            "sub_cate_id": subCatID,
            "is_animated" : isAnimated
        ]
        
        //print(param)
        
        MBProgressHUD.showAdded(to: self.view, animated: true)
        
        AF.request(API_STICKER_LIST, method: .post, parameters: param).responseJSON { response in
            //print(response)
            MBProgressHUD.hide(for: self.view, animated: true)
            if((response.value) != nil) {
                var dic: NSDictionary = [:]
                dic = response.value as! NSDictionary
                
                if(dic["ResponseCode"] as! String == "1") {
                    
                    let dicData = (dic["data"] as! NSDictionary).mutableCopy() as! NSMutableDictionary
                    self.aryList = (dicData["sticker_list"] as! NSArray).mutableCopy() as! NSMutableArray
                    
                    if self.aryList.count > 0 {
                        self.imgTray.isHidden = false
                        self.lblTitle.isHidden = false
                        self.lblTotal.isHidden = false
                        self.btnDownload.isHidden = false
                        self.lblEx.isHidden = false
                        if self.isAnimated == "YES" {
                            self.lblTotal.text = "\(self.aryList.count) Stickers (Animated)"
                        } else {
                            self.lblTotal.text = "\(self.aryList.count) Stickers"
                        }
                        self.stickersCollectionView.reloadData()
                    } else {
                        self.imgTray.isHidden = true
                        self.lblTitle.isHidden = true
                        self.lblTotal.isHidden = true
                        self.btnDownload.isHidden = true
                        self.lblEx.isHidden = true
                        self.showAction(strMessage: "No Sticker Available")
                    }
                } else {
                    self.imgTray.isHidden = true
                    self.lblTitle.isHidden = true
                    self.lblTotal.isHidden = true
                    self.btnDownload.isHidden = true
                    self.lblEx.isHidden = true
                    self.showAction(strMessage: dic["ResponseMsg"] as! String)
                }
            } else {
                self.imgTray.isHidden = true
                self.lblTitle.isHidden = true
                self.lblTotal.isHidden = true
                self.btnDownload.isHidden = true
                self.lblEx.isHidden = true
                let alert = UIAlertController(title: "MESSAGE", message: "Network Problem", preferredStyle: .alert)
                alert.addAction(UIAlertAction(title: "Try Again", style: .default, handler: { action in
                    self.getData()
                }))
                self.present(alert, animated: true, completion: nil)
            }
        }
    }
 
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        if (stickerPack != nil) {
            return stickerPack.stickers.count
        } else {
            return aryList.count
        }
    }
    
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        
        let cell = collectionView.dequeueReusableCell(withReuseIdentifier: "PackCell", for: indexPath) as! PackCell
        
        cell.layer.borderWidth = 0.3
        cell.layer.borderColor = UIColor.lightGray.cgColor
        
        var dic : NSMutableDictionary = [:]
        dic = (aryList.object(at: indexPath.row) as! NSDictionary).mutableCopy() as! NSMutableDictionary
        
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
        dic = (aryList.object(at: indexPath.row) as! NSDictionary).mutableCopy() as! NSMutableDictionary
        
        showActionSheet(overCell: cell!, strUrl: dic["sticker_image"] as! String)
        
    }
    
    func collectionView(_ collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, sizeForItemAt indexPath: IndexPath) -> CGSize {

        let noOfCellsInRow = 3

        let flowLayout = collectionViewLayout as! UICollectionViewFlowLayout

        let totalSpace = flowLayout.sectionInset.left
                + flowLayout.sectionInset.right
                + (flowLayout.minimumInteritemSpacing * CGFloat(noOfCellsInRow - 1))

        let size = Int((collectionView.bounds.width - totalSpace) / CGFloat(noOfCellsInRow))

        return CGSize(width: size, height: size)
        
    }
    
    // MARK: Button Action
    @IBAction func btnBackClick(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    @IBAction func btnDownloadClick(_ sender: Any) {
        if aryList.count >= 3 {
            if aryList.count <= 30 {
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
            } else {
                showAlert(strMessage: "Maximum 30 Stickers should be there in sticker pack.")
            }
        } else {
            showAlert(strMessage: "Atleast 3 Stickers required in sticker pack.")
        }
    }
    
    // MARK: Method
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
    
    func showAction(strMessage: String)  {
        let alertController = UIAlertController(title: "ALERT", message: strMessage, preferredStyle: .alert)
        let okAction = UIAlertAction(title: "OK", style: UIAlertAction.Style.default) {
            UIAlertAction in
            self.navigationController?.popViewController(animated: true)
        }
        alertController.addAction(okAction)
        self.present(alertController, animated: true, completion: nil)
    }
    
    func showAlert(strMessage: String)  {
        let alert = UIAlertController(title: "MESSAGE", message: strMessage, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: "OK", style: UIAlertAction.Style.default, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    
    func makePack()  {
        
        MBProgressHUD.showAdded(to: self.view, animated: true)
        
        let aryStickerPack : NSMutableArray = []
        
        let aryBlank : NSMutableArray = []
        aryBlank.add("")
        aryBlank.add("")
        
        dicMain.setValue(I_App, forKey: "ios_app_store_link")
        dicMain.setValue(A_App, forKey: "android_play_store_link")
        
        let dicStickerPack : NSMutableDictionary = [:]
        dicStickerPack.setValue(subCatID, forKey: "identifier")
        dicStickerPack.setValue(strTitle, forKey: "name")
        dicStickerPack.setValue("Sticker.ly", forKey: "publisher")
        dicStickerPack.setValue(strTrayUrl, forKey: "tray_image_file")
        dicStickerPack.setValue("", forKey: "publisher_website")
        dicStickerPack.setValue("", forKey: "privacy_policy_website")
        dicStickerPack.setValue("", forKey: "license_agreement_website")
        
        if isAnimated == "YES" {
            dicStickerPack.setValue(true, forKey: "animated_sticker_pack")
        } else {
            dicStickerPack.setValue(false, forKey: "animated_sticker_pack")
        }
        
        let arySticker : NSMutableArray = []
        
        for i in 0..<aryList.count {
            var dic : NSMutableDictionary = [:]
            dic = (aryList.object(at: i) as! NSDictionary).mutableCopy() as! NSMutableDictionary
            let dicSticker : NSMutableDictionary = [:]
            dicSticker.setValue(dic["sticker_image"] as! String, forKey: "image_file")
            dicSticker.setValue(aryBlank, forKey: "emojis")
            arySticker.add(dicSticker)
        }
        
        dicStickerPack.setValue(arySticker, forKey: "stickers")
        
        aryStickerPack.add(dicStickerPack)
        
        dicMain.setValue(aryStickerPack, forKey: "sticker_packs")
        
        if let theJSONData = try? JSONSerialization.data(
            withJSONObject: dicMain,
            options: []) {

            let theJSONText = String(data: theJSONData,
                                     encoding: .utf8)
            
            let data = theJSONText?.data(using: .utf8)!
            do {
                if let jsonArray = try JSONSerialization.jsonObject(with: data!, options : .allowFragments) as? Dictionary<String,Any> {
                    dicFinal = jsonArray
                    fetchStickerPacks()
                } else {
                    //print("bad json")
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
