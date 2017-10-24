Forlagshuset Legacy INI Bundle
==================

Replace EzPublish Legacy ini config with yaml files.

This bundle is based on legacy settings injection mechanism (https://doc.ez.no/display/EZP/Legacy+configuration+injection).
INI settings can be injected per siteaccess group.


Installation
------------------

Install bundle using composer: `composer require "forlagshuset/legacy-ini-bundle:*"`

Add `new Forlagshuset\LegacyIniBundle\ForlagshusetLegacyIniBundle()` to `app/AppKernel.php`

Create `app/config/legacy.yml` file and put `forlagshuset_legacy_ini` configuration inside (example for Netgen Admin UI below).

Add `- { resource: legacy.yml }` to `imports` section in ezplatform.yml


Usage example
------------------

Basic settings for Netgen Admin UI:

```
forlagshuset_legacy_ini:
    enabled_legacy_settings:
        - site.ini
    system:
        ngadmin_group:
            injected_settings:
                content.ini:
                    VersionView/AvailableSiteDesignList:
                        - admin2
                        - admin
                site.ini:
                    DatabaseSettings/SQLOutput: disabled
                    ContentSettings/ViewCaching: enabled
                    OverrideSettings/Cache: enabled
                    TemplateSettings/Debug: disabled
                    TemplateSettings/DevelopmentMode: disabled
                    TemplateSettings/TemplateCache: enabled
                    TemplateSettings/TemplateCompile: enabled
                    TemplateSettings/ShowUsedTemplates: disabled
                    TemplateSettings/ShowXHTMLCode: disabled
                    DebugSettings/DebugOutput: disabled
                    DebugSettings/DebugRedirection: disabled

                    DesignSettings/SiteDesign: ngadminui
                    DesignSettings/AdditionalSiteDesignList:
                        - admin2
                        - admin
                        - standard
                        - base

        site_group:
            injected_settings:
                content.ini:
                    VersionView/AvailableSiteDesignList:
                        - admin2
                        - admin
                site.ini:
                    DatabaseSettings/SQLOutput: disabled
                    ContentSettings/ViewCaching: enabled
                    OverrideSettings/Cache: enabled
                    TemplateSettings/Debug: disabled
                    TemplateSettings/DevelopmentMode: disabled
                    TemplateSettings/TemplateCache: enabled
                    TemplateSettings/TemplateCompile: enabled
                    TemplateSettings/ShowUsedTemplates: disabled
                    TemplateSettings/ShowXHTMLCode: disabled
                    DebugSettings/DebugOutput: disabled
                    DebugSettings/DebugRedirection: disabled

        default:
            injected_settings:
                site.ini:
                    FileSettings/VarDir: var/site
                    Session/SessionNameHandler: custom
                    UserSettings/LogoutRedirect: /
                    DesignSettings/DesignLocationCache: enabled

                    MailSettings/Transport: sendmail
                    MailSettings/AdminEmail: ez_dev@forlagshuset.no
                    MailSettings/EmailSender: ez_dev@forlagshuset.no

                    ExtensionSettings/ExtensionOrdering: enabled
                    ExtensionSettings/ActiveExtensions:
                        - ngadminui
                        - ezplatformsearch
                        - ngsymfonytools
                        - ezclasslists
                        - ezchangeclass
                        - enhancedselection2
                        - ezmultiupload
                        - ezjscore
                        - ezgmaplocation
                        - ezdemo
                        - ezflow
                        - ezoe

                    SiteSettings/DefaultAccess: site
                    SiteSettings/RootNodeDepth: 1
                    SiteSettings/SiteList:
                        - site
                        - site_admin
                        - ngadmin

                    SiteAccessRules/Rules:
                        - access;disable
                        - module;user/register
                        - module;user/activate
                        - module;user/unactivated
                        - module;user/success
                        - module;user/forgotpassword
                        - module;ezinfo/about
                        - module;ezinfo/copyright
                        - module;content/tipafriend
                        - module;settings/edit
                        - module;visual
                        - module;shop

                    SiteAccessSettings/CheckValidity: false
                    SiteAccessSettings/MatchOrder: uri
                    SiteAccessSettings/AvailableSiteAccessList:
                        - site
                        - site_admin
                        - ngadmin
```


Authors Information
------------------

This Bundle was created in 2017 by Ivan Herak (https://netgenlabs.com) and Igor Makowski (https://forlagshuset.no)
