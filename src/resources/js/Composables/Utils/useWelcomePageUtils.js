import { reactive } from 'vue'
import useWelcomePageSettings from '@/Composables/Settings/useWelcomePageSettings.js'

const { main_banner, gallery, overview, main_categories, carousel_sliders, about_us, features, gallery_swipers, brands, footers,
    getCarouselSliders
  } = useWelcomePageSettings()

export default function useWelcomePageUtils(){
    const WPUtilsRes = reactive({
        main_banner : null,
        gallery: null,

    })

    function initializeWelcomePage(welcome_page_settings){
        if(welcome_page_settings.main_banner != null){
            let main_banner_json = JSON.parse(welcome_page_settings.main_banner)
        
            if(main_banner_json != null && main_banner_json != ''){
                if(main_banner_json.banner_url != null){
                    main_banner.banner_url = main_banner_json.banner_url
                    main_banner.hide_logo  = main_banner_json.hide_logo
                }else{
                    main_banner.banner_url = '/images/banner.jpg'
                    main_banner.hide_logo  = "0"
                }

                main_banner.header_logo_url  = main_banner_json.header_logo_url
                main_banner.header_menu_text = main_banner_json.header_menu_text
        
                main_banner.banner_text     = main_banner_json.banner_text
                main_banner.header          = main_banner_json.header
                main_banner.footer_text     = main_banner_json.footer_text
                main_banner.main_text       = main_banner_json.main_text
                main_banner.sub_text        = main_banner_json.sub_text
                main_banner.main_text2      = main_banner_json.main_text2
                main_banner.sub_text2       = main_banner_json.sub_text2
                main_banner.overlay_url     = main_banner_json.overlay_url
                
        
            }else{
                main_banner.banner_url = '/images/banner.jpg'
                main_banner.hide_logo = "0"
            }

            WPUtilsRes.main_banner = main_banner
        }
        
        if(welcome_page_settings.gallery != null){
            let gallery_json = JSON.parse(welcome_page_settings.gallery)
            if(gallery_json != null && gallery_json != ''){
                gallery.title          = gallery_json.title
                gallery.subtitle       = gallery_json.subtitle
                gallery.overlay_url    = gallery_json.overlay_url
        
                if(gallery_json.slides != null){
                    gallery.slides      = gallery_json.slides
                    if(gallery.slides != null){
                        gallery.slides.forEach((slide, index) => {
                            slide.bg_img = slide.bg
                            slide.bg = null
                        });
                    }
                }
            }

            WPUtilsRes.gallery = gallery
        }
        
        if(welcome_page_settings.overview != null){
            let overview_json = JSON.parse(welcome_page_settings.overview)
            if(overview_json != null && overview_json != ''){
                overview.top_sub_text   = overview_json.top_sub_text
                overview.main_text      = overview_json.main_text
                overview.sub_text       = overview_json.sub_text
                overview.buttons        = overview_json.buttons
                overview.overlay_url    = overview_json.overlay_url
            }

            WPUtilsRes.overview = overview
        }

    }

    return {
        initializeWelcomePage,
        WPUtilsRes
    }
}