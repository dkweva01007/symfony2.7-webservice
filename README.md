# Webservice #

extension de page possible pour afficher le resultat:
* xml
* json

extension de page à ne pas uttiliser pour afficher le resultat:
* html : il faut créer un template.

Route notable:
 nelmio_api_doc_index              GET      ANY    ANY  /api/doc/{view}
 fos_user_security_login           GET|POST ANY    ANY  /login                                              
 fos_user_security_check           POST     ANY    ANY  /login_check  
 get_website                       GET      ANY    ANY  /service/websites/{id}.{_format}                    
 get_websites                      GET      ANY    ANY  /service/websites.{_format}                         
 delete_website                    DELETE   ANY    ANY  /service/websites/{id}.{_format}                    
 put_website                       PUT      ANY    ANY  /service/websites/{id}.{_format}                    
 post_organisation                 POST     ANY    ANY  /service/organisations.{_format}                    
 get_account                       GET      ANY    ANY  /service/accounts/{id}.{_format}                    
 get_accounts                      GET      ANY    ANY  /service/accounts.{_format}                         
 delete_account                    DELETE   ANY    ANY  /service/accounts/{id}.{_format}                    
 put_account                       PUT      ANY    ANY  /service/accounts/{id}.{_format}                    
 post_account                      POST     ANY    ANY  /service/accounts.{_format}                         
 get_accounthistoric_by_website    GET      ANY    ANY  /service/accounthistoric_by_websites/{id}.{_format} 
 get_accounthistoric_by_user       GET      ANY    ANY  /service/accounthistoric_by_users/{id}.{_format}    
 get_accounthistorics              GET      ANY    ANY  /service/accounthistorics.{_format}                 
 post_accounthistoric              POST     ANY    ANY  /service/accounthistorics.{_format}