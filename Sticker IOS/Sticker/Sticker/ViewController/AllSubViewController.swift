//
//  AllSubViewController.swift
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

class AllSubViewController: UIViewController,UICollectionViewDataSource, UICollectionViewDelegate, UICollectionViewDelegateFlowLayout  {

    var aryList : NSMutableArray = []
    var catID : String = ""
    var subCatID : String = ""
    var strTitle : String = ""
    var strTrayUrl : String = ""
    var strType : String = ""
    var isAnimated : String = ""
    
    @IBOutlet weak var lblTitle: UILabel!
    @IBOutlet weak var cView: UICollectionView!
    @IBOutlet weak var viewBanner: GADBannerView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        lblTitle.text = strTitle
        getData()
        cView.reloadData()
        setLayout()
        loadBannerAd()
    }
    
    override func viewWillAppear(_ animated: Bool) {
//        setLayout()
//        loadBannerAd()
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    // MARK: Retrive data from server
    func getData() {
    
        let param: Parameters = ["category_id": catID]
        
        //print(param)
        
        MBProgressHUD.showAdded(to: self.view, animated: true)
        
        AF.request(API_SUB_CATEGORY_LIST, method: .post, parameters: param).responseJSON { response in
            //print(response)
            MBProgressHUD.hide(for: self.view, animated: true)
            if((response.value) != nil) {
                var dic: NSDictionary = [:]
                dic = response.value as! NSDictionary
                
                if(dic["ResponseCode"] as! String == "1") {
                    var di : NSMutableDictionary = [:]
                    di = (dic["data"] as! NSDictionary).mutableCopy() as! NSMutableDictionary
                    self.aryList = (di["sub_cate_list"] as! NSArray).mutableCopy() as! NSMutableArray
                    self.cView.reloadData()
                } else {
                    self.showAlert(strMessage: dic["ResponseMsg"] as! String)
                }
            } else {
                let alert = UIAlertController(title: "MESSAGE", message: "Network Problem", preferredStyle: .alert)
                alert.addAction(UIAlertAction(title: "Try Again", style: .default, handler: { action in
                    self.getData()
                }))
                self.present(alert, animated: true, completion: nil)
            }
        }
    }
    
    // MARK: Collection view method
    func collectionView(_ collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, sizeForItemAt indexPath: IndexPath) -> CGSize {
        if (UIDevice().type.rawValue == "iPhone 5S" || UIDevice().type.rawValue == "iPhone 5C" || UIDevice().type.rawValue == "iPhone 5" || UIDevice().type.rawValue == "iPhone 4S" || UIDevice().type.rawValue == "iPhone 4" || UIDevice().type.rawValue == "iPhone SE") {
            let padding: CGFloat =  12
            let collectionViewSize = collectionView.frame.size.width - padding
            
            return CGSize(width: collectionViewSize/2, height: collectionViewSize/2)

        } else {
            let width = collectionView.bounds.width
            let cellWidth = (width - 30) / 3
            return CGSize(width: cellWidth, height: cellWidth)
        }
    }
    
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        return aryList.count
    }
    
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        
        let cell = collectionView.dequeueReusableCell(withReuseIdentifier: "SubCell", for: indexPath) as! SubCell
        
        var di : NSMutableDictionary = [:]
        di = (aryList.object(at: indexPath.row) as! NSDictionary).mutableCopy() as! NSMutableDictionary
        
        let activityIndicator = UIActivityIndicatorView.init(style: UIActivityIndicatorView.Style.gray)
        activityIndicator.center = cell.imgView.center
        activityIndicator.hidesWhenStopped = true
        activityIndicator.startAnimating()
        cell.imgView.addSubview(activityIndicator)
        cell.imgView.sd_setImage(with: URL(string: di["sub_cate_image"] as! String), completed: { (image: UIImage?, error: Error?, cacheType: SDImageCacheType, imageURL: URL?) in
            activityIndicator.removeFromSuperview()
        })
        
        cell.lblTitle.text = di["sub_cate_name"] as? String
        
        return cell
    }
    
    func collectionView(_ collectionView: UICollectionView, didSelectItemAt indexPath: IndexPath) {
        
        var dic : NSMutableDictionary = [:]
        dic = (aryList[indexPath.row] as! NSDictionary).mutableCopy() as! NSMutableDictionary
        subCatID = dic["sub_cate_id"] as! String
        strTitle = dic["sub_cate_name"] as! String
        strTrayUrl = dic["sub_cate_tray_image"] as! String
        isAnimated = dic["is_animated"] as! String
        
        strType = "pack_sub"
        showAds()
        
    }
    
    // MARK: Method
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if segue.identifier == "pack_sub" {
            let controller = segue.destination as! PackViewController
            controller.strTitle = strTitle
            controller.catID = catID
            controller.subCatID = subCatID
            controller.strTrayUrl = strTrayUrl
            controller.isAnimated = isAnimated
        }
    }
    
    func showAlert(strMessage: String)  {
        let alert = UIAlertController(title: "MESSAGE", message: strMessage, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: "OK", style: UIAlertAction.Style.default, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    
    // MARK: Button Action
    @IBAction func btnBackClick(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    // MARK: Admob Ads Method
    func setLayout() {
        if UIDevice.current.modelName == "iPhone 4" || UIDevice.current.modelName == "iPhone 4s" || UIDevice.current.modelName == "iPhone 5" || UIDevice.current.modelName == "iPhone 5c" || UIDevice.current.modelName == "iPhone 5s" || UIDevice.current.modelName == "iPhone 6" || UIDevice.current.modelName == "iPhone 6 Plus" || UIDevice.current.modelName == "iPhone 6s" || UIDevice.current.modelName == "iPhone 6s Plus" || UIDevice.current.modelName == "iPhone 7" || UIDevice.current.modelName == "iPhone 7 Plus" || UIDevice.current.modelName == "iPhone SE" || UIDevice.current.modelName == "iPhone 8" || UIDevice.current.modelName == "iPhone 8 Plus"{
            
        } else {
            cView.frame = CGRect(x: cView.frame.origin.x, y: cView.frame.origin.y, width: cView.frame.size.width, height: self.view.frame.size.height - 72 - 66 - 8)
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
