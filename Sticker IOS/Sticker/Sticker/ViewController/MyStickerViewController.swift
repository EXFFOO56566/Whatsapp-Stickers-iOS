//
//  MyStickerViewController.swift
//  Sticker
//
//  Created by Mehul on 19/06/19.
//  Copyright © 2019 Mehul. All rights reserved.
//

import UIKit
import GoogleMobileAds
import SDWebImage

class MyStickerViewController: UIViewController,UITableViewDelegate,UITableViewDataSource {

    var strType : String = ""
    var arySticker : NSMutableArray = []
    var dicSend : NSMutableDictionary = [:]
    
    @IBOutlet weak var tblView: UITableView!
    @IBOutlet weak var viewBanner: GADBannerView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        setLayout()
        loadBannerAd()
        
        let defaults = UserDefaults.standard
        if(defaults.object(forKey: "custom_sticker") == nil) {
            let alert = UIAlertController(title: "ALERT", message: "Sticker Pack Not Available", preferredStyle: .alert)
            alert.addAction(UIAlertAction(title: "OK", style: .default, handler: { action in
                self.navigationController?.popViewController(animated: true)
            }))
            self.present(alert, animated: true, completion: nil)
        } else {
            arySticker = (defaults.object(forKey: "custom_sticker") as! NSArray).mutableCopy() as! NSMutableArray
            if(arySticker.count > 0){
                tblView.reloadData()
            } else {
                let alert = UIAlertController(title: "ALERT", message: "Sticker Pack Not Available", preferredStyle: .alert)
                alert.addAction(UIAlertAction(title: "OK", style: .default, handler: { action in
                    self.navigationController?.popViewController(animated: true)
                }))
                self.present(alert, animated: true, completion: nil)
            }
        }
    }
    
    override func viewWillAppear(_ animated: Bool) {
        
//        setLayout()
//        loadBannerAd()
//
//        let defaults = UserDefaults.standard
//        if(defaults.object(forKey: "custom_sticker") == nil) {
//            let alert = UIAlertController(title: "ALERT", message: "Sticker Pack Not Available", preferredStyle: .alert)
//            alert.addAction(UIAlertAction(title: "OK", style: .default, handler: { action in
//                self.navigationController?.popViewController(animated: true)
//            }))
//            self.present(alert, animated: true, completion: nil)
//        } else {
//            arySticker = (defaults.object(forKey: "custom_sticker") as! NSArray).mutableCopy() as! NSMutableArray
//            if(arySticker.count > 0){
//                tblView.reloadData()
//            } else {
//                let alert = UIAlertController(title: "ALERT", message: "Sticker Pack Not Available", preferredStyle: .alert)
//                alert.addAction(UIAlertAction(title: "OK", style: .default, handler: { action in
//                    self.navigationController?.popViewController(animated: true)
//                }))
//                self.present(alert, animated: true, completion: nil)
//            }
//        }
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    // MARK: Tableview Method
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return arySticker.count
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        
        let cell : MyStickerCell = tableView.dequeueReusableCell(withIdentifier: "MyStickerCell") as! MyStickerCell
        
        cell.viewMain.layer.cornerRadius = 25.0
        cell.viewSub.layer.cornerRadius = 23.0
        cell.imgTray.layer.cornerRadius = 23.0
        cell.viewMain.layer.masksToBounds = true
        cell.viewSub.layer.masksToBounds = true
        cell.imgTray.layer.masksToBounds = true
        
        var dic : NSMutableDictionary = [:]
        dic = (arySticker[indexPath.row] as! NSDictionary).mutableCopy() as! NSMutableDictionary
        cell.lblName.text = dic["pack_name"] as? String
        
        let activityIndicator = UIActivityIndicatorView.init(style: UIActivityIndicatorView.Style.gray)
        activityIndicator.center = cell.imgTray.center
        activityIndicator.hidesWhenStopped = true
        activityIndicator.startAnimating()
        cell.imgTray.addSubview(activityIndicator)
        
        cell.imgTray.sd_setImage(with: URL(string: dic["tray_image"] as! String), completed: { (image: UIImage?, error: Error?, cacheType: SDImageCacheType, imageURL: URL?) in
            activityIndicator.removeFromSuperview()
        })
        
        
        var arySub : NSMutableArray = []
        arySub = (dic["sticker"] as! NSArray).mutableCopy() as! NSMutableArray
        
        for view in cell.sView.subviews {
            view.removeFromSuperview()
        }
        
        var xPos : Float = 0.0
        for i in 0 ..< arySub.count {
            var dicSub : NSMutableDictionary = [:]
            dicSub = (arySub[i] as! NSDictionary).mutableCopy() as! NSMutableDictionary
            
            let v = UIView(frame: CGRect(x: Double(xPos), y: 0.0, width: 78, height: 78))
            v.backgroundColor = UIColor.clear
            
            let imgView = UIImageView(frame: CGRect(x: 4, y: 4, width: 70, height: 70))
            
            let activityIndicator = UIActivityIndicatorView.init(style: UIActivityIndicatorView.Style.gray)
            activityIndicator.center = imgView.center
            activityIndicator.hidesWhenStopped = true
            activityIndicator.startAnimating()
            v.addSubview(imgView)
            
            imgView.sd_setImage(with: URL(string: dicSub["sticker_image"] as! String), completed: { (image: UIImage?, error: Error?, cacheType: SDImageCacheType, imageURL: URL?) in
                activityIndicator.removeFromSuperview()
            })
            
            xPos = xPos + 78 + 8
            
            cell.sView.addSubview(v)
            cell.sView.contentSize = CGSize(width: Int(xPos-8), height: 0)
        }
        
        cell.btnEdit.tag = indexPath.row
        cell.btnDelete.tag = indexPath.row
        cell.btnSelect.tag = indexPath.row
    cell.btnDelete.addTarget(self,action:#selector(deleteClicked(sender:)), for: .touchUpInside)
    cell.btnEdit.addTarget(self,action:#selector(editClicked(sender:)), for: .touchUpInside)
    cell.btnSelect.addTarget(self,action:#selector(selectClicked(sender:)), for: .touchUpInside)
        
        return cell
    }
    
    // MARK: Button Action
    @IBAction func btnBackClick(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    @objc func deleteClicked(sender:UIButton) {
        let alert = UIAlertController(title: "CONFIRMATION", message: "Are you sure to Delete??", preferredStyle: .alert)
        
        alert.addAction(UIAlertAction(title: "No", style: .cancel, handler: { action in
        }))
        alert.addAction(UIAlertAction(title: "Yes", style: .destructive, handler: { action in
            self.arySticker.removeObject(at: sender.tag)
            let defaults = UserDefaults.standard
            defaults.set(self.arySticker, forKey: "custom_sticker")
            self.tblView.reloadData()
        }))
        self.present(alert, animated: true, completion: nil)
    }
    
    @objc func editClicked(sender:UIButton) {
        dicSend = (arySticker[sender.tag] as! NSDictionary).mutableCopy() as! NSMutableDictionary
        strType = "edit"
        showAds()
    }
    
    @objc func selectClicked(sender:UIButton) {
        dicSend = (arySticker[sender.tag] as! NSDictionary).mutableCopy() as! NSMutableDictionary
        strType = "pack_my"
        showAds()
    }
    
    // MARK: Method
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if segue.identifier == "pack_my" {
            let controller = segue.destination as! CustomPackViewController
            controller.dicSticker = dicSend
        }
        if segue.identifier == "edit" {
            let controller = segue.destination as! EditViewController
            controller.dicSticker = dicSend
        }
    }
    
    // MARK: Admob Ads Method
    func setLayout() {
        if UIDevice.current.modelName == "iPhone 4" || UIDevice.current.modelName == "iPhone 4s" || UIDevice.current.modelName == "iPhone 5" || UIDevice.current.modelName == "iPhone 5c" || UIDevice.current.modelName == "iPhone 5s" || UIDevice.current.modelName == "iPhone 6" || UIDevice.current.modelName == "iPhone 6 Plus" || UIDevice.current.modelName == "iPhone 6s" || UIDevice.current.modelName == "iPhone 6s Plus" || UIDevice.current.modelName == "iPhone 7" || UIDevice.current.modelName == "iPhone 7 Plus" || UIDevice.current.modelName == "iPhone SE" || UIDevice.current.modelName == "iPhone 8" || UIDevice.current.modelName == "iPhone 8 Plus"{
            
        } else {
            tblView.frame = CGRect(x: tblView.frame.origin.x, y: tblView.frame.origin.y, width: tblView.frame.size.width, height: self.view.frame.size.height - 72 - 66 - 8)
            viewBanner.frame = CGRect(x: viewBanner.frame.origin.x, y: self.view.frame.size.height - 66, width: viewBanner.frame.size.width, height: viewBanner.frame.size.height)
        }
    }
    
    func loadBannerAd() {
        viewBanner.adUnitID = BannerAD
        viewBanner.rootViewController = self
        viewBanner.load(GADRequest())
    }
    
    func showAds() {
        AdmobManager.shared.showAds(vw: self, str: strType)
    }
    
    func sendToAdmob(str : String) {
        AdmobManager.shared.requestAds()
        self.performSegue(withIdentifier: str, sender: self)
    }

}
