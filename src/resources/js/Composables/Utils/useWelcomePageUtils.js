import { reactive } from 'vue'
import useWelcomePageSettings from '@/Composables/Settings/useWelcomePageSettings.js'

const { main_banner, gallery, overview, main_categories, carousel_sliders, about_us, features, gallery_swipers, brands, footers, virtual_tours, maps
    } = useWelcomePageSettings()

export default function useWelcomePageUtils(){
    const WPUtilsRes = reactive({
        main_banner : null,
        gallery: null,
        overview: null,
        main_categories: null,
        carousel_sliders: null,
        about_us: null,
        features: null,
        gallery_swipers: null,
        brands: null,
        footers: null,
        virtual_tours: null,
        maps: null,
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

                if(overview_json.slides != null){
                    overview.slides      = overview_json.slides
                    if(overview.slides != null){
                        overview.slides.forEach((slide, index) => {
                            slide.bg_img = slide.bg
                            slide.bg = null
                        });
                    }
                }
            }

            WPUtilsRes.overview = overview
        }

        if(welcome_page_settings.carousel != null){
            let carousel_sliders_json = JSON.parse(welcome_page_settings.carousel)
            if(carousel_sliders_json != null && carousel_sliders_json != ''){
                carousel_sliders.header         = carousel_sliders_json.header
                carousel_sliders.main_text      = carousel_sliders_json.main_text
                if(carousel_sliders_json.slides != null){
                    carousel_sliders.slides      = carousel_sliders_json.slides
                    if(carousel_sliders.slides != null){
                        carousel_sliders.slides.forEach((slide, index) => {
                            slide.bg_img = slide.bg
                            slide.bg = null
                        });
                    }
                }

                carousel_sliders.overlay_img      = carousel_sliders_json.overlay_url != null ? carousel_sliders_json.overlay_url: null
            }
            
            WPUtilsRes.carousel_sliders = carousel_sliders
        }

        if(welcome_page_settings.main_categories != null){
            let main_categories_json = JSON.parse(welcome_page_settings.main_categories)
            if(main_categories_json != null && main_categories_json != ''){
                main_categories.title    = main_categories_json.title
                main_categories.subtitle = main_categories_json.subtitle
                main_categories.overlay_url     = main_categories_json.overlay_url
                main_categories.links    = main_categories_json.links
            }

            WPUtilsRes.main_categories = main_categories
        }

        if(welcome_page_settings.features != null){
            let features_json = JSON.parse(welcome_page_settings.features)
            if(features_json != null && features_json != ''){
                features.title          = features_json.title
                features.subtitle       = features_json.subtitle
                features.links          = features_json.links
                features.overlay_url    = features_json.overlay_url
            }

            WPUtilsRes.features = features
        }

        if(welcome_page_settings.about_us != null){
            let about_us_json = JSON.parse(welcome_page_settings.about_us)
            if(about_us_json != null && about_us_json != ''){
                about_us.top_sub_text    = about_us_json.top_sub_text
                about_us.sub_text        = about_us_json.sub_text
                about_us.main_text       = about_us_json.main_text
                about_us.header          = about_us_json.header
                about_us.team_members    = about_us_json.team_members
                about_us.team_leader_name        = about_us_json.team_leader_name
                about_us.team_leader_position    = about_us_json.team_leader_position
                about_us.team_leader_profile_img = about_us_json.team_leader_profile_url
                about_us.overlay_url     = about_us_json.overlay_url
                about_us.menus    = about_us_json.menus
            }

            WPUtilsRes.about_us = about_us
        }

        if(welcome_page_settings.swiper_gallery != null){
            let swiper_gallery_json = JSON.parse(welcome_page_settings.swiper_gallery)
            if(swiper_gallery_json != null && swiper_gallery_json != ''){
                gallery_swipers.title          = swiper_gallery_json.title
                gallery_swipers.subtitle       = swiper_gallery_json.subtitle
                gallery_swipers.overlay_url    = swiper_gallery_json.overlay_url

                if(swiper_gallery_json.slides != null){
                    gallery_swipers.slides      = swiper_gallery_json.slides
                    if(gallery_swipers.slides != null){
                        gallery_swipers.slides.forEach((slide, index) => {
                            slide.bg_img = slide.bg
                            slide.bg = null
                        });
                    }
                }
            }

            WPUtilsRes.gallery_swipers = gallery_swipers
        }

        if(welcome_page_settings.brands != null){
            let brands_json = JSON.parse(welcome_page_settings.brands)
            if(brands_json != null && brands_json != ''){
                brands.title          = brands_json.title
                brands.subtitle       = brands_json.subtitle
                brands.overlay_url    = brands_json.overlay_url

                if(brands_json.links != null){
                    brands.links      = brands_json.links
                    if(brands.links != null){
                        brands.links.forEach((link, index) => {
                            link.bg_img = link.bg
                            link.bg = null
                        });
                    }
                }
            }

            WPUtilsRes.brands = brands
        }

        if(welcome_page_settings.footers != null){
            let footers_json = JSON.parse(welcome_page_settings.footers)
            if(footers_json != null && footers_json != ''){
                footers.title          = footers_json.title
                footers.subtitle       = footers_json.subtitle
                footers.overlay_url    = footers_json.overlay_url

                if(footers_json.links != null){
                    footers.links      = footers_json.links
                    if(footers.links != null){
                        footers.links.forEach((link, index) => {
                            link.bg_img = link.bg
                            link.bg = null
                        });

                    }
                }
            }

            WPUtilsRes.footers = footers
        }

        if(welcome_page_settings.virtual_tours != null){
            let virtual_tours_json = JSON.parse(welcome_page_settings.virtual_tours)
            if(virtual_tours_json != null && virtual_tours_json != ''){
                virtual_tours.title          = virtual_tours_json.title

                if(virtual_tours_json.links != null){
                    virtual_tours.links      = virtual_tours_json.links
                    if(virtual_tours.links != null){
                        virtual_tours.links.forEach((link, index) => {
                            link.bg_img = link.bg
                            link.bg = null
                        });
                    }
                }
            }

            WPUtilsRes.virtual_tours = virtual_tours
        }

        if(welcome_page_settings.maps != null){
            let maps_json = JSON.parse(welcome_page_settings.maps)
            if(maps_json != null && maps_json != ''){
                maps.title          = maps_json.title
                maps.subtitle       = maps_json.subtitle
                maps.overlay_url    = maps_json.overlay_url
                maps.map_url        = maps_json.map_url
               
            }

            WPUtilsRes.maps = maps
        }

    }

    return {
        initializeWelcomePage,
        WPUtilsRes
    }
}