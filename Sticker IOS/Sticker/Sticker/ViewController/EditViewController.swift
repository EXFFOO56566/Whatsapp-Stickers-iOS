//
//  Edit1ViewController.swift
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

class EditViewController: UIViewController,UITableViewDelegate,UITableViewDataSource,UITextFieldDelegate {

    var strType : String = ""
    var dicSticker : NSMutableDictionary = [:]
    var aryList : NSMutableArray = []
    var aryMain : NSMutableArray = []
    var dicCategory : NSMutableDictionary = [:]
    var strIcon : String = ""
    var arySticker : NSMutableArray = []
    var aryMySticker : NSMutableArray = []
    var dicSend : NSMutableDictionary = [:]
    
    @IBOutlet weak var viewCategory: UIView!
    @IBOutlet weak var sMain: UIScrollView!
    @IBOutlet weak var lblCategory: UILabel!
    @IBOutlet weak var sView: UIScrollView!
    @IBOutlet weak var tblView: UITableView!
    @IBOutlet weak var mySview: UIScrollView!
    @IBOutlet weak var txtName: UITextField!
    @IBOutlet weak var viewSuccess: UIView!
    @IBOutlet weak var viewBanner: GADBannerView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        sMain.contentSize = CGSize(width: 0, height: 565)
        
        setLayout()
        loadBannerAd()
        
        viewCategory.isHidden = true
        viewSuccess.isHidden = true
        txtName.text = dicSticker["pack_name"] as? String
        aryMySticker = (dicSticker["sticker"] as!  NSArray).mutableCopy() as! NSMutableArray
        mySticker()
        getData()
    }
    
    override func viewWillAppear(_ animated: Bool) {
//        setLayout()
//        loadBannerAd()
//        
//        viewCategory.isHidden = true
//        viewSuccess.isHidden = true
//        txtName.text = dicSticker["pack_name"] as? String
//        aryMySticker = (dicSticker["sticker"] as!  NSArray).mutableCopy() as! NSMutableArray
//        mySticker()
//        getData()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    // MARK: Retrive data from server
    func getData() {
        
        lblCategory.text = "Select Category"
        
        MBProgressHUD.showAdded(to: self.view, animated: true)
        
        AF.request(API_HOME_LIST, method: .post, parameters: nil).responseJSON { response in
             //print(response)
             MBProgressHUD.hide(for: self.view, animated: true)
             if((response.value) != nil) {
                var dic: NSDictionary = [:]
                dic = response.value as! NSDictionary
                
                if(dic["ResponseCode"] as! String == "1") {
                    var dicData : NSDictionary = [:]
                    dicData = dic["data"] as! NSDictionary
                    
                    self.aryMain = []
                    self.aryList = (dicData["category_list"] as! NSArray).mutableCopy() as! NSMutableArray
                    
                    for i in self.aryList {
                        var dic : NSMutableDictionary = [:]
                        dic = (i as! NSDictionary).mutableCopy() as! NSMutableDictionary
                        
                        var ary : NSMutableArray = []
                        ary = (dic["sub_category"] as! NSArray).mutableCopy() as! NSMutableArray
                        
                        for j in ary {
                            var dic : NSMutableDictionary = [:]
                            dic = (j as! NSDictionary).mutableCopy() as! NSMutableDictionary
                            self.aryMain.add(dic)
                        }
                    }
                    self.dicCategory = self.aryMain.object(at: 0) as! NSMutableDictionary
                    self.lblCategory.text = self.dicCategory.value(forKey: "sub_cate_name") as? String
                    self.strIcon = self.dicCategory["sub_cate_tray_image"] as! String
                    self.getSticker()
                    if(self.aryMain.count > 0) {
                        self.tblView.reloadData()
                    } else {
                        self.lblCategory.text = "Select Category"
                        self.dicCategory = [:]
                    }
                    
                } else {
                    self.showAlert(strMessage: dic["ResponseMsg"] as! String)
                    self.lblCategory.text = "Select Category"
                    self.dicCategory = [:]
                }
             } else {
                 self.lblCategory.text = "Select Category"
                 self.dicCategory = [:]
                 let alert = UIAlertController(title: "MESSAGE", message: "Network Problem", preferredStyle: .alert)
                 alert.addAction(UIAlertAction(title: "Try Again", style: .default, handler: { action in
                     self.getData()
                 }))
                 self.present(alert, animated: true, completion: nil)
             }
         }
    }
    
    func getSticker() {
        
        var strID : String = ""
        strID = dicCategory.object(forKey: "sub_cate_id") as! String
        
        let param: Parameters = ["sub_cate_id": strID,
                                 "is_animated" : dicCategory.object(forKey: "is_animated") as! String]
        
        MBProgressHUD.showAdded(to: self.view, animated: true)
        
        AF.request(API_STICKER_LIST, method: .post, parameters: param).responseJSON { response in
             //print(response)
             MBProgressHUD.hide(for: self.view, animated: true)
            
             if((response.value) != nil) {
                 
                var dic: NSDictionary = [:]
                dic = response.value as! NSDictionary
                 
                if(dic["ResponseCode"] as! String == "1") {

                    var di : NSMutableDictionary = [:]
                    di = (dic["data"] as! NSDictionary).mutableCopy() as! NSMutableDictionary
                    
                    self.arySticker = []
                    
                    let aryEx = (di["sticker_list"] as! NSArray).mutableCopy() as! NSMutableArray
                    for i in aryEx {
                        var dic : NSMutableDictionary = [:]
                        dic = (i as! NSDictionary).mutableCopy() as! NSMutableDictionary
                        
                        let dicNew : NSMutableDictionary = [:]
                        dicNew.setValue(dic["sticker_id"] as! String, forKey: "sticker_id")
                        dicNew.setValue(dic["sticker_image"] as! String, forKey: "sticker_image")
                        dicNew.setValue(dic["sub_cate_id"] as! String, forKey: "sub_cate_id")
                        dicNew.setValue(self.dicCategory["is_animated"] as! String, forKey: "is_animated")
                        
                        self.arySticker.add(dicNew)
                        
                    }
                    
                    self.setSticker()
                } else {
                    self.lblCategory.text = "Select Category"
                    self.dicCategory = [:]
                    for view in self.sView.subviews {
                        view.removeFromSuperview()
                    }
                    self.showAlert(strMessage: dic["ResponseMsg"] as! String)
                }
             } else {
                 self.lblCategory.text = "Select Category"
                 self.dicCategory = [:]
                 for view in self.sView.subviews {
                     view.removeFromSuperview()
                 }
                 let alert = UIAlertController(title: "MESSAGE", message: "Network Problem", preferredStyle: .alert)
                 alert.addAction(UIAlertAction(title: "Try Again", style: .default, handler: { action in
                     self.getSticker()
                 }))
                 self.present(alert, animated: true, completion: nil)
             }
         }
    }
    
    // MARK: Tableview Method
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return aryMain.count
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "CategoryCell", for: indexPath) as! CategoryCell
        
        var dic : NSMutableDictionary = [:]
        dic = self.aryMain.object(at: indexPath.row) as! NSMutableDictionary
        
        cell.lblName.text = dic.object(forKey: "sub_cate_name") as? String
        
        return cell
    }
    
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        dicCategory = self.aryMain.object(at: indexPath.row) as! NSMutableDictionary
        strIcon = self.dicCategory["sub_cate_tray_image"] as! String
        self.lblCategory.text = self.dicCategory.value(forKey: "sub_cate_name") as? String
        viewCategory.isHidden = true
        getSticker()
    }
    
    // MARK: Button Action
    @objc func btnAddTapped(button: UIButton) {
        
        if self.aryMySticker.count >= 30 {
            showAlert(strMessage: "You can add max 20 Stickers to Sticker Pack")
        } else {
            
            var dicSub : NSMutableDictionary = [:]
            dicSub = (self.arySticker[button.tag] as! NSDictionary).mutableCopy() as! NSMutableDictionary
            
            var strID : String = ""
            strID = dicSub["sticker_id"] as! String
            
            var isAvail : Bool = false
            
            for i in 0 ..< self.aryMySticker.count {
                var dic : NSMutableDictionary = [:]
                dic = (self.aryMySticker[i] as! NSDictionary).mutableCopy() as! NSMutableDictionary
                if(dic["sticker_id"] as! String == strID) {
                    isAvail = true
                    break
                }
            }
            
            if isAvail {
                
                showAlert(strMessage: "Sticker Already Added")
                
            } else {
                
                if aryMySticker.count <= 0 {
                    
                    let dic : NSMutableDictionary = [:]
                    dic.setValue(dicSub["sticker_id"] as! String, forKey: "sticker_id")
                    dic.setValue(dicSub["sticker_image"] as! String, forKey: "sticker_image")
                    dic.setValue(dicSub["sub_cate_id"] as! String, forKey: "sub_cate_id")
                    dic.setValue(strIcon, forKey: "tray_img")
                    dic.setValue(dicSub["is_animated"] as! String, forKey: "is_animated")
                    
                    aryMySticker.add(dic)
                    mySticker()
                    
                } else {
                    
                    if isAnimatedExist() == true  {
                        
                        if dicSub["is_animated"] as! String == "YES" {
                            
                            let dic : NSMutableDictionary = [:]
                            
                            dic.setValue(dicSub["sticker_id"] as! String, forKey: "sticker_id")
                            dic.setValue(dicSub["sticker_image"] as! String, forKey: "sticker_image")
                            dic.setValue(dicSub["sub_cate_id"] as! String, forKey: "sub_cate_id")
                            dic.setValue(strIcon, forKey: "tray_img")
                            dic.setValue(dicSub["is_animated"] as! String, forKey: "is_animated")
                            
                            aryMySticker.add(dic)
                            mySticker()
                            
                        } else {
                            
                            showAlert(strMessage: "You can add only animated sticker.")
                            
                        }
                        
                    } else {
                        
                        if dicSub["is_animated"] as! String == "NO" {
                            
                            let dic : NSMutableDictionary = [:]
                            dic.setValue(dicSub["sticker_id"] as! String, forKey: "sticker_id")
                            dic.setValue(dicSub["sticker_image"] as! String, forKey: "sticker_image")
                            dic.setValue(dicSub["sub_cate_id"] as! String, forKey: "sub_cate_id")
                            dic.setValue(strIcon, forKey: "tray_img")
                            dic.setValue(dicSub["is_animated"] as! String, forKey: "is_animated")
                            
                            aryMySticker.add(dic)
                            mySticker()
                            
                        } else {
                            
                            showAlert(strMessage: "You can't add animated sticker.")
                            
                        }
                    }
                    
                }
                
            }
        }
    }
    
    @objc func btnRemoveTapped(button: UIButton) {
        aryMySticker.removeObject(at: button.tag)
        mySticker()
    }
    
    @IBAction func btnBackClick(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    @IBAction func btnSelectCategoryClick(_ sender: Any) {
        if(self.aryMain.count > 0) {
            viewCategory.isHidden = false
        }
    }
    
    @IBAction func btnUpdateClick(_ sender: Any) {
        if (self.aryMySticker.count >= 3) {
            //save edited data
            var ary : NSMutableArray = []
            let defaults = UserDefaults.standard
            ary = (defaults.object(forKey: "custom_sticker") as! NSArray).mutableCopy() as! NSMutableArray
            
            var inNumber : Int = 0
            for i in 0 ..< ary.count {
                var dicSub : NSMutableDictionary = [:]
                dicSub = (ary[i] as! NSDictionary).mutableCopy() as! NSMutableDictionary
                if(dicSub["pack_name"] as? String == dicSticker["pack_name"] as? String) {
                    inNumber = i
                    break
                }
            }
            ary.removeObject(at: inNumber)
            
            let dic : NSMutableDictionary = [:]
            dic.setValue(txtName.text, forKey: "pack_name")
            dic.setValue(dicSticker["tray_image"] as? String, forKey: "tray_image")
            dic.setValue(aryMySticker, forKey: "sticker")
            ary.add(dic)
            defaults.set(ary, forKey: "custom_sticker")
            
            dicSend = dic
            
            viewSuccess.isHidden = false
            
        } else {
            showAlert(strMessage: "Atleast 3 Sticker Required In Sticker Pack")
        }
    }
    
    @IBAction func btnCancelClick(_ sender: Any) {
        let alert = UIAlertController(title: "WARNING", message: "Changes you made will be Lost", preferredStyle: .alert)
        
        alert.addAction(UIAlertAction(title: "Cancel", style: .cancel, handler: { action in
        }))
        alert.addAction(UIAlertAction(title: "Ok", style: .destructive, handler: { action in
            self.navigationController?.popViewController(animated: true)
        }))
        self.present(alert, animated: true, completion: nil)
    }
    
    @IBAction func btnOkClick(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
    @IBAction func btnSendToWhatsClick(_ sender: Any) {
        strType = "pack_edit"
        showAds()
    }
    
    // MARK: Method
    func setSticker() {
        
        for view in sView.subviews {
            view.removeFromSuperview()
        }
        
        var xPos : Float = 0.0
        for i in 0 ..< self.arySticker.count {
            var dicSub : NSMutableDictionary = [:]
            dicSub = (self.arySticker[i] as! NSDictionary).mutableCopy() as! NSMutableDictionary
            
            let v = UIView(frame: CGRect(x: Double(xPos), y: 0.0, width: 100, height: 148))
            v.backgroundColor = UIColor.clear
            //v.layer.cornerRadius = 3.0
            v.layer.borderWidth = 0.5
            v.layer.borderColor = UIColor(red: 48/255, green: 166/255, blue: 75/255, alpha: 1).cgColor
            
            
            let imgView = UIImageView(frame: CGRect(x: 10, y: 10, width: 80, height: 80))
            imgView.backgroundColor = UIColor.clear
            
            let activityIndicator = UIActivityIndicatorView.init(style: UIActivityIndicatorView.Style.gray)
            activityIndicator.center = imgView.center
            activityIndicator.hidesWhenStopped = true
            activityIndicator.startAnimating()
            imgView.addSubview(activityIndicator)
            v.addSubview(imgView)
            imgView.sd_setImage(with: URL(string: dicSub["sticker_image"] as! String), completed: { (image: UIImage?, error: Error?, cacheType: SDImageCacheType, imageURL: URL?) in
                activityIndicator.removeFromSuperview()
            })
            
            
            
            let btn = UIButton(frame: CGRect(x: 8, y: 108, width: 84, height: 30))
            btn.tag = i
            btn.backgroundColor = UIColor(red: 48/255, green: 166/255, blue: 75/255, alpha: 1)
            btn.setTitle("ADD", for: UIControl.State.normal)
            btn.addTarget(self, action: #selector(btnAddTapped(button:)), for: .touchUpInside)
            v.addSubview(btn)
            
            xPos = xPos + 100 + 8
            
            sView.addSubview(v)
            sView.contentSize = CGSize(width: Int(xPos-8), height: 0)
        }
    }
    
    func mySticker() {
        
        for view in mySview.subviews {
            view.removeFromSuperview()
        }
        
        var xPos : Float = 0.0
        for i in 0 ..< 30 {
            
            let v = UIView(frame: CGRect(x: Double(xPos), y: 0.0, width: 100, height: 148))
            v.backgroundColor = UIColor.clear
            v.layer.borderWidth = 0.5
            v.layer.borderColor = UIColor(red: 48/255, green: 166/255, blue: 75/255, alpha: 1).cgColor
            
            if(self.aryMySticker.count > i) {
                var dicSub : NSMutableDictionary = [:]
                dicSub = (self.aryMySticker[i] as! NSDictionary).mutableCopy() as! NSMutableDictionary
                
                let imgView = UIImageView(frame: CGRect(x: 10, y: 10, width: 80, height: 80))
                imgView.backgroundColor = UIColor.clear
                
                let activityIndicator = UIActivityIndicatorView.init(style: UIActivityIndicatorView.Style.gray)
                activityIndicator.center = imgView.center
                activityIndicator.hidesWhenStopped = true
                activityIndicator.startAnimating()
                imgView.addSubview(activityIndicator)
                v.addSubview(imgView)
                imgView.sd_setImage(with: URL(string: dicSub["sticker_image"] as! String), completed: { (image: UIImage?, error: Error?, cacheType: SDImageCacheType, imageURL: URL?) in
                    activityIndicator.removeFromSuperview()
                })
                
                let btn = UIButton(frame: CGRect(x: 8, y: 108, width: 84, height: 30))
                btn.tag = i
                btn.backgroundColor = UIColor(red: 48/255, green: 166/255, blue: 75/255, alpha: 1)
                btn.setTitle("REMOVE", for: UIControl.State.normal)
                btn.addTarget(self, action: #selector(btnRemoveTapped(button:)), for: .touchUpInside)
                v.addSubview(btn)
            } else {
                
                let lbl = UILabel(frame: CGRect(x: 10, y: 108, width: 80, height: 32))
                lbl.backgroundColor = UIColor.clear
                lbl.textAlignment = NSTextAlignment.center
                lbl.textColor = UIColor.black
                lbl.text = "\(i+1)"
                v.addSubview(lbl)
                
                let imgView = UIImageView(frame: CGRect(x: 10, y: 10, width: 80, height: 80))
                imgView.image = UIImage(named: "add")
                imgView.backgroundColor = UIColor.clear
                v.addSubview(imgView)
            }
            
            xPos = xPos + 100 + 8
            
            mySview.addSubview(v)
            mySview.contentSize = CGSize(width: Int(xPos-8), height: 0)
        }
    }

    
    func showAlert(strMessage: String)  {
        let alert = UIAlertController(title: "MESSAGE", message: strMessage, preferredStyle: UIAlertController.Style.alert)
        alert.addAction(UIAlertAction(title: "OK", style: UIAlertAction.Style.default, handler: nil))
        self.present(alert, animated: true, completion: nil)
    }
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if segue.identifier == "pack_edit" {
            let controller = segue.destination as! CustomPackViewController
            controller.dicSticker = dicSend
            controller.strFrom = "create"
        }
    }
    
    func textFieldShouldReturn(_ scoreText: UITextField) -> Bool {
        self.view.endEditing(true)
        return false
    }
    
    func isAnimatedExist() -> Bool {
        
        var isAvail : Bool = false
        for i in 0 ..< self.aryMySticker.count {
            var dic : NSMutableDictionary = [:]
            dic = (self.aryMySticker[i] as! NSDictionary).mutableCopy() as! NSMutableDictionary
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
            sMain.frame = CGRect(x: sMain.frame.origin.x, y: sMain.frame.origin.y, width: sMain.frame.size.width, height: self.view.frame.size.height - 72 - 66 - 8)
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
