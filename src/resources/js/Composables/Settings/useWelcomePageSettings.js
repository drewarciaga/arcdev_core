import { ref, reactive } from 'vue'

export default function useWelcomePageSettings(){
    const main_banner_errors                = ref([])
    const overview_errors                   = ref([])
    const about_us_errors                   = ref([])
    const main_categories_errors            = ref([])
    const carousel_sliders_errors           = ref([])
    const features_errors                   = ref([])
    const gallery_errors                    = ref([])
    const gallery_swipers_errors            = ref([])
    const brands_errors                     = ref([])
    const footers_errors                    = ref([])
    const virtual_tours_errors              = ref([])

    const main_banner = reactive({
        banner_url: null,
        banner_img: null,
        banner_thumb_url: null,
        banner_thumb_img: null,
        delete_banner_url: false,
        hide_logo: '0',
        banner_text: '',
        header: '',
        main_text: '',
        sub_text: '',
        main_text2: '',
        sub_text2: '',
        footer_text: '',
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
        header_logo_url: null,
        header_logo_img: null,
        delete_header_logo_url: false,
        header_menu_text: 'My Logo',
    })

    const overview = reactive({
        top_sub_text: '',
        main_text: '',
        sub_text: '',
        buttons: [],
        slides: [],
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const about_us = reactive({
        top_sub_text: '',
        sub_text: '',
        main_text: '',
        header: '',
        team_members: [],
        team_leader_name: '',
        team_leader_position: '',
        team_leader_profile_url: null,
        team_leader_profile_img: null,
        delete_leader_profile_image: false,
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const main_categories = reactive({
        title: '',
        subtitle: '',
        links: [],
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const gallery_swipers = reactive({
        title: '',
        subtitle: '',
        slides: [],
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const carousel_sliders = reactive({
        header: '',
        main_text: '',
        slides: [],
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const features = reactive({
        title: '',
        subtitle: '',
        links: [],
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const brands = reactive({
        title: '',
        subtitle: '',
        links: [],
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const footers = reactive({
        title: '',
        subtitle: '',
        links: [],
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const gallery = reactive({
        title: '',
        subtitle: '',
        slides: [],
        overlay_url: null,
        overlay_img: null,
        delete_overlay_url: false,
    })

    const virtual_tours = reactive({
        title: '',
        links: [],
    })

    function resetFields(){
        main_categories.links  = []
        carousel_sliders.slides = []
        gallery_swipers.slides  = []
        gallery.slides  = []
        overview.slides = []
    }

    /** START MAIN BANNER **/
    async function getMainBanner(){
        await axios.get('/getMainBanner').then(response => {
            if(response.data.main_banner != null){
                main_banner.banner_img          = response.data.main_banner.banner_url
                main_banner.banner_thumb_img    = response.data.main_banner.banner_thumb_url

                main_banner.header_logo_img     = response.data.main_banner.header_logo_url
                main_banner.header_menu_text    = response.data.main_banner.header_menu_text

                if(response.data.main_banner.hide_logo != null){
                    main_banner.hide_logo    = response.data.main_banner.hide_logo.toString()
                }

                main_banner.banner_text = response.data.main_banner.banner_text != null ? response.data.main_banner.banner_text: ''
                main_banner.header      = response.data.main_banner.header != null ? response.data.main_banner.header: ''
                main_banner.main_text   = response.data.main_banner.main_text != null ? response.data.main_banner.main_text: ''
                main_banner.sub_text    = response.data.main_banner.sub_text != null ? response.data.main_banner.sub_text: ''
                main_banner.main_text2  = response.data.main_banner.main_text2 != null ? response.data.main_banner.main_text2: ''
                main_banner.sub_text2   = response.data.main_banner.sub_text2 != null ? response.data.main_banner.sub_text2: ''
                main_banner.footer_text = response.data.main_banner.footer_text != null ? response.data.main_banner.footer_text: ''
                main_banner.overlay_img = response.data.main_banner.overlay_url != null ? response.data.main_banner.overlay_url: null
            }
        });
    }

    function setFormDataMainBanner(){
        let formData = new FormData();

        if(main_banner.banner_url !=null){
            formData.append('banner_url', main_banner.banner_url, main_banner.banner_url.name);
        }
        
        if(main_banner.delete_banner_url == true){
            formData.append('delete_banner_url', main_banner.delete_banner_url);
        }

        if(main_banner.header_logo_url !=null){
            formData.append('header_logo_url', main_banner.header_logo_url, main_banner.header_logo_url.name);
        }
        
        if(main_banner.delete_header_logo_url == true){
            formData.append('delete_header_logo_url', main_banner.delete_header_logo_url);
        }

        if(main_banner.header_menu_text !=null){
            formData.append('header_menu_text', main_banner.header_menu_text);
        }

        if(main_banner.hide_logo != null){
            formData.append('hide_logo', main_banner.hide_logo);
        }

        if(main_banner.banner_text !=null){
            formData.append('banner_text', main_banner.banner_text);
        }

        if(main_banner.header !=null){
            formData.append('header', main_banner.header);
        }

        if(main_banner.main_text !=null){
            formData.append('main_text', main_banner.main_text);
        }

        if(main_banner.sub_text !=null){
            formData.append('sub_text', main_banner.sub_text);
        }

        if(main_banner.main_text2 !=null){
            formData.append('main_text2', main_banner.main_text2);
        }

        if(main_banner.sub_text2 !=null){
            formData.append('sub_text2', main_banner.sub_text2);
        }

        if(main_banner.footer_text !=null){
            formData.append('footer_text', main_banner.footer_text);
        }

        if(main_banner.overlay_url !=null){
            formData.append('overlay_url', main_banner.overlay_url, main_banner.overlay_url.name);
        }

        if(main_banner.delete_overlay_url == true){
            formData.append('delete_overlay_url', main_banner.delete_overlay_url);
        }
        
        return formData;
    }

    async function storeMainBanner(){
        main_banner_errors.value = []

        let formData = setFormDataMainBanner();

        await axios.post('/saveMainBanner',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                main_banner_errors.value = error.response.data.errors
            }
        });
    }
    /** END MAIN BANNER **/

    /** START OVERVIEW **/
    async function getOverview(){
        await axios.get('/getOverview').then(response => {
            if(response.data.overview != null){
                overview.top_sub_text           = response.data.overview.top_sub_text
                overview.main_text              = response.data.overview.main_text
                overview.sub_text               = response.data.overview.sub_text
                overview.buttons                = response.data.overview.buttons != null ? response.data.overview.buttons : []
                overview.overlay_img            = response.data.overview.overlay_url != null ? response.data.overview.overlay_url: null
                overview.slides                 = (response.data.overview.slides != null) ? response.data.overview.slides : []
                overview.slides.forEach((slide, index) => {
                    slide.bg_img = slide.bg
                    slide.bg = null
                });
            }
        });
    }

    function setFormDataOverview(){
        let formData = new FormData();

        if(overview.top_sub_text !=null){
            formData.append('top_sub_text', overview.top_sub_text);
        }
        
        if(overview.main_text !=null){
            formData.append('main_text', overview.main_text);
        }

        if(overview.sub_text !=null){
            formData.append('sub_text', overview.sub_text);
        }

        if(overview.buttons != null && (overview.buttons.length > 0)){
            formData.append('buttons', JSON.stringify(overview.buttons));
        }

        if(overview.overlay_url !=null){
            formData.append('overlay_url', overview.overlay_url, overview.overlay_url.name);
        }

        if(overview.delete_overlay_url !== null && overview.delete_overlay_url == true){
            formData.append('delete_overlay_url', overview.delete_overlay_url);
        }

        if(overview.slides != null && (overview.slides.length > 0)){
            formData.append('slides', JSON.stringify(overview.slides));

            overview.slides.forEach((slide, index) => {
                if(slide.bg != null && slide.bg.name != null){
                    formData.append('slide'+index.toString(), slide.bg, slide.bg.name);
                }else if(slide.bg_img != null){
                    formData.append('existing_slide'+index.toString(), slide.bg_img);
                }
            });
        }
        
        return formData;
    }

    async function storeOverview(){
        overview_errors.value = []

        let formData = setFormDataOverview();

        await axios.post('/saveOverview',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                overview_errors.value = error.response.data.errors
            }
        });
    }
    /** END OVERVIEW **/

    /** START MAIN CATEGORIES **/
    async function getMainCategories(){
        await axios.get('/getMainCategories').then(response => {
            if(response.data.main_categories != null){
                main_categories.title           = response.data.main_categories.title
                main_categories.subtitle        = response.data.main_categories.subtitle
                main_categories.links           = (response.data.main_categories.links != null) ? response.data.main_categories.links : []
                main_categories.links.forEach((link, index) => {
                    link.bg_img = link.bg
                    link.bg = null
                });
                main_categories.overlay_img     = response.data.main_categories.overlay_url != null ? response.data.main_categories.overlay_url: null
            }
        });
    }

    function setFormDataMainCategories(){
        let formData = new FormData();

        if(main_categories.title !=null){
            formData.append('title', main_categories.title);
        }
        
        if(main_categories.subtitle !=null){
            formData.append('subtitle', main_categories.subtitle);
        }

        if(main_categories.links != null && (main_categories.links.length > 0)){
            formData.append('links', JSON.stringify(main_categories.links));

            main_categories.links.forEach((link, index) => {
                if(link.bg != null && link.bg.name != null){
                    formData.append('link'+index.toString(), link.bg, link.bg.name);
                }else if(link.bg_img != null){
                    formData.append('existing_link'+index.toString(), link.bg_img);
                }
            });
        }

        if(main_categories.overlay_url !=null){
            formData.append('overlay_url', main_categories.overlay_url, main_categories.overlay_url.name);
        }

        if(main_categories.delete_overlay_url == true){
            formData.append('delete_overlay_url', main_categories.delete_overlay_url);
        }

        return formData;
    }

    async function storeMainCategories(){
        main_categories_errors.value = []

        let formData = setFormDataMainCategories();

        await axios.post('/saveMainCategories',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                main_categories_errors.value = error.response.data.errors
            }
        });
    }
    /** END MAIN CATEGORIES **/

    /** START GALLERY SWIPERS **/
    async function getGallerySwipers(){
        await axios.get('/getGallerySwipers').then(response => {
            if(response.data.gallery_swipers != null){
                gallery_swipers.title            = response.data.gallery_swipers.title
                gallery_swipers.subtitle         = response.data.gallery_swipers.subtitle
                gallery_swipers.slides           = (response.data.gallery_swipers.slides != null) ? response.data.gallery_swipers.slides : []
                gallery_swipers.slides.forEach((slide, index) => {
                    slide.bg_img = slide.bg
                    slide.bg = null
                });
                gallery_swipers.overlay_img      = response.data.gallery_swipers.overlay_url != null ? response.data.gallery_swipers.overlay_url: null
            }
        });
    }

    function setFormDataGallerySwipers(){
        let formData = new FormData();

        if(gallery_swipers.title !=null){
            formData.append('title', gallery_swipers.title);
        }
        
        if(gallery_swipers.subtitle !=null){
            formData.append('subtitle', gallery_swipers.subtitle);
        }

        if(gallery_swipers.slides != null && (gallery_swipers.slides.length > 0)){
            formData.append('slides', JSON.stringify(gallery_swipers.slides));

            gallery_swipers.slides.forEach((slide, index) => {
                if(slide.bg != null && slide.bg.name != null){
                    formData.append('slide'+index.toString(), slide.bg, slide.bg.name);
                }else if(slide.bg_img != null){
                    formData.append('existing_slide'+index.toString(), slide.bg_img);
                }
            });
        }
        
        if(gallery_swipers.overlay_url !=null){
            formData.append('overlay_url', gallery_swipers.overlay_url, gallery_swipers.overlay_url.name);
        }

        if(gallery_swipers.delete_overlay_url == true){
            formData.append('delete_overlay_url', gallery_swipers.delete_overlay_url);
        }

        return formData;
    }

    async function storeGallerySwipers(){
        gallery_swipers_errors.value = []

        let formData = setFormDataGallerySwipers();

        await axios.post('/saveGallerySwipers',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                gallery_swipers_errors.value = error.response.data.errors
            }
        });
    }
    /** END GALLERY SWIPERS **/

    /** START CAROUSEL SLIDERS **/
    async function getCarouselSliders(){
        await axios.get('/getCarouselSliders').then(response => {
            if(response.data.carousel_sliders != null){
                carousel_sliders.header          = response.data.carousel_sliders.header
                carousel_sliders.main_text       = response.data.carousel_sliders.main_text
                carousel_sliders.slides          = (response.data.carousel_sliders.slides != null) ? response.data.carousel_sliders.slides : []
                carousel_sliders.slides.forEach((slide, index) => {
                    slide.bg_img = slide.bg
                    slide.bg = null
                });
                carousel_sliders.overlay_img      = response.data.carousel_sliders.overlay_url != null ? response.data.carousel_sliders.overlay_url: null
            }
        });
    }

    function setFormDataCarouselSliders(){
        let formData = new FormData();

        if(carousel_sliders.header !=null){
            formData.append('header', carousel_sliders.header);
        }
        
        if(carousel_sliders.main_text !=null){
            formData.append('main_text', carousel_sliders.main_text);
        }

        if(carousel_sliders.slides != null && (carousel_sliders.slides.length > 0)){
            formData.append('slides', JSON.stringify(carousel_sliders.slides));

            carousel_sliders.slides.forEach((slide, index) => {
                if(slide.bg != null && slide.bg.name != null){
                    formData.append('slide'+index.toString(), slide.bg, slide.bg.name);
                }else if(slide.bg_img != null){
                    formData.append('existing_slide'+index.toString(), slide.bg_img);
                }
            });
        }

        if(carousel_sliders.overlay_url !=null){
            formData.append('overlay_url', carousel_sliders.overlay_url, carousel_sliders.overlay_url.name);
        }

        if(carousel_sliders.delete_overlay_url == true){
            formData.append('delete_overlay_url', carousel_sliders.delete_overlay_url);
        }
        
        return formData;
    }

    async function storeCarouselSliders(){
        carousel_sliders_errors.value = []

        let formData = setFormDataCarouselSliders();

        await axios.post('/saveCarouselSliders',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                carousel_sliders_errors.value = error.response.data.errors
            }
        });
    }
    /** END CAROUSEL SLIDERS **/

    /** START ABOUT US **/
    async function getAboutUs(){
        await axios.get('/getAboutUs').then(response => {
            if(response.data.about_us != null){
                about_us.top_sub_text            = response.data.about_us.top_sub_text
                about_us.main_text               = response.data.about_us.main_text
                about_us.sub_text                = response.data.about_us.sub_text
                about_us.header                  = response.data.about_us.header

                about_us.team_leader_name        = response.data.about_us.team_leader_name
                about_us.team_leader_position    = response.data.about_us.team_leader_position
                about_us.team_leader_profile_img = response.data.about_us.team_leader_profile_url
                about_us.team_leader_profile_url   = null

                about_us.team_members            = (response.data.about_us.team_members != null) ? response.data.about_us.team_members : []
                about_us.team_members.forEach((team_member, index) => {
                    team_member.profile_img = team_member.image_url
                    team_member.image_url = null
                });

                about_us.overlay_img             = response.data.about_us.overlay_url != null ? response.data.about_us.overlay_url: null
            }
        });
    }

    function setFormDataAboutUs(){
        let formData = new FormData();

        if(about_us.top_sub_text !=null){
            formData.append('top_sub_text', about_us.top_sub_text);
        }
        
        if(about_us.main_text !=null){
            formData.append('main_text', about_us.main_text);
        }

        if(about_us.sub_text !=null){
            formData.append('sub_text', about_us.sub_text);
        }

        if(about_us.header !=null){
            formData.append('header', about_us.header);
        }

        if(about_us.team_leader_name != null){
            formData.append('team_leader_name', about_us.team_leader_name);
        }

        if(about_us.team_leader_position != null){
            formData.append('team_leader_position', about_us.team_leader_position);
        }

        if(about_us.team_leader_profile_url != null && about_us.team_leader_profile_url.name != null){
            formData.append('team_leader_profile_url'.toString(), about_us.team_leader_profile_url, about_us.team_leader_profile_url.name);
        }

        if(about_us.delete_leader_profile_image == true){
            formData.append('delete_leader_profile_image', about_us.delete_leader_profile_image);
        }
        
        if(about_us.team_members != null && (about_us.team_members.length > 0)){
            formData.append('team_members', JSON.stringify(about_us.team_members));

            about_us.team_members.forEach((team_member, index) => {
                if(team_member.image_url != null && team_member.image_url.name != null){
                    formData.append('team_member'+index.toString(), team_member.image_url, team_member.image_url.name);
                }else if(team_member.profile_img != null){
                    formData.append('existing_profile'+index.toString(), team_member.profile_img);
                }
            });
        }

        if(about_us.overlay_url !=null){
            formData.append('overlay_url', about_us.overlay_url, about_us.overlay_url.name);
        }

        if(about_us.delete_overlay_url == true){
            formData.append('delete_overlay_url', about_us.delete_overlay_url);
        }
        
        return formData;
    }

    async function storeAboutUs(){
        about_us_errors.value = []

        let formData = setFormDataAboutUs();

        await axios.post('/saveAboutUs',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                about_us_errors.value = error.response.data.errors
            }
        });
    }
    /** END ABOUT US **/

    /** START FEATURES **/
    async function getFeatures(){
        await axios.get('/getFeatures').then(response => {
            if(response.data.features != null){
                features.title           = response.data.features.title
                features.subtitle        = response.data.features.subtitle
                features.links           = (response.data.features.links != null) ? response.data.features.links : []
                features.links.forEach((link, index) => {
                    link.bg_img = link.bg
                    link.bg = null
                });
                features.overlay_img     = response.data.features.overlay_url != null ? response.data.features.overlay_url: null
            }
        });
    }

    function setFormDataFeatures(){
        let formData = new FormData();

        if(features.title !=null){
            formData.append('title', features.title);
        }
        
        if(features.subtitle !=null){
            formData.append('subtitle', features.subtitle);
        }

        if(features.links != null && (features.links.length > 0)){
            formData.append('links', JSON.stringify(features.links));

            features.links.forEach((link, index) => {
                if(link.bg != null && link.bg.name != null){
                    formData.append('link'+index.toString(), link.bg, link.bg.name);
                }else if(link.bg_img != null){
                    formData.append('existing_link'+index.toString(), link.bg_img);
                }
            });
        }

        if(features.overlay_url !=null){
            formData.append('overlay_url', features.overlay_url, features.overlay_url.name);
        }

        if(features.delete_overlay_url == true){
            formData.append('delete_overlay_url', features.delete_overlay_url);
        }

        return formData;
    }

    async function storeFeatures(){
        features_errors.value = []

        let formData = setFormDataFeatures();

        await axios.post('/saveFeatures',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                features_errors.value = error.response.data.errors
            }
        });
    }
    /** END FEATURES **/

    /** START BRANDS **/
    async function getBrands(){
        await axios.get('/getBrands').then(response => {
            if(response.data.brands != null){
                brands.title           = response.data.brands.title
                brands.subtitle        = response.data.brands.subtitle
                brands.links           = (response.data.brands.links != null) ? response.data.brands.links : []
                brands.links.forEach((link, index) => {
                    link.bg_img = link.bg
                    link.bg = null
                });
                brands.overlay_img     = response.data.brands.overlay_url != null ? response.data.brands.overlay_url: null
            }
        });
    }

    function setFormDataBrands(){
        let formData = new FormData();

        if(brands.title !=null){
            formData.append('title', brands.title);
        }
        
        if(brands.subtitle !=null){
            formData.append('subtitle', brands.subtitle);
        }

        if(brands.links != null && (brands.links.length > 0)){
            formData.append('links', JSON.stringify(brands.links));

            brands.links.forEach((link, index) => {
                if(link.bg != null && link.bg.name != null){
                    formData.append('link'+index.toString(), link.bg, link.bg.name);
                }else if(link.bg_img != null){
                    formData.append('existing_link'+index.toString(), link.bg_img);
                }
            });
        }

        if(brands.overlay_url !=null){
            formData.append('overlay_url', brands.overlay_url, brands.overlay_url.name);
        }

        if(brands.delete_overlay_url == true){
            formData.append('delete_overlay_url', brands.delete_overlay_url);
        }

        return formData;
    }

    async function storeBrands(){
        brands_errors.value = []

        let formData = setFormDataBrands();

        await axios.post('/saveBrands',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                brands_errors.value = error.response.data.errors
            }
        });
    }
    /** END BRANDS **/

    /** START FOOTER **/
    async function getFooters(){
        await axios.get('/getFooters').then(response => {
            if(response.data.footers != null){
                footers.title           = response.data.footers.title
                footers.subtitle        = response.data.footers.subtitle
                footers.links           = (response.data.footers.links != null) ? response.data.footers.links : []
                footers.links.forEach((link, index) => {
                    link.bg_img = link.bg
                    link.bg = null
                });
                footers.overlay_img     = response.data.footers.overlay_url != null ? response.data.footers.overlay_url: null
            }
        });
    }

    function setFormDataFooters(){
        let formData = new FormData();

        if(footers.title !=null){
            formData.append('title', footers.title);
        }
        
        if(footers.subtitle !=null){
            formData.append('subtitle', footers.subtitle);
        }

        if(footers.links != null && (footers.links.length > 0)){
            formData.append('links', JSON.stringify(footers.links));

            footers.links.forEach((link, index) => {
                if(link.bg != null && link.bg.name != null){
                    formData.append('link'+index.toString(), link.bg, link.bg.name);
                }else if(link.bg_img != null){
                    formData.append('existing_link'+index.toString(), link.bg_img);
                }
            });
        }

        if(footers.overlay_url !=null){
            formData.append('overlay_url', footers.overlay_url, footers.overlay_url.name);
        }

        if(footers.delete_overlay_url == true){
            formData.append('delete_overlay_url', footers.delete_overlay_url);
        }

        return formData;
    }

    async function storeFooters(){
        footers_errors.value = []

        let formData = setFormDataFooters();

        await axios.post('/saveFooters',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                footers_errors.value = error.response.data.errors
            }
        });
    }
    /** END FOOTER **/

    /** START GALLERY **/
    async function getGallery(){
        await axios.get('/getGallery').then(response => {
            if(response.data.gallery != null){
                gallery.title            = response.data.gallery.title
                gallery.subtitle         = response.data.gallery.subtitle
                gallery.slides           = (response.data.gallery.slides != null) ? response.data.gallery.slides : []
                gallery.slides.forEach((slide, index) => {
                    slide.bg_img = slide.bg
                    slide.bg = null
                });
                gallery.overlay_img      = response.data.gallery.overlay_url != null ? response.data.gallery.overlay_url: null
            }
        });
    }

    function setFormDataGallery(){
        let formData = new FormData();

        if(gallery.title !=null){
            formData.append('title', gallery.title);
        }
        
        if(gallery.subtitle !=null){
            formData.append('subtitle', gallery.subtitle);
        }

        if(gallery.slides != null && (gallery.slides.length > 0)){
            formData.append('slides', JSON.stringify(gallery.slides));

            gallery.slides.forEach((slide, index) => {
                if(slide.bg != null && slide.bg.name != null){
                    formData.append('slide'+index.toString(), slide.bg, slide.bg.name);
                }else if(slide.bg_img != null){
                    formData.append('existing_slide'+index.toString(), slide.bg_img);
                }
            });
        }
        
        if(gallery.overlay_url !=null){
            formData.append('overlay_url', gallery.overlay_url, gallery.overlay_url.name);
        }

        if(gallery.delete_overlay_url == true){
            formData.append('delete_overlay_url', gallery.delete_overlay_url);
        }

        return formData;
    }

    async function storeGallery(){
        gallery_errors.value = []

        let formData = setFormDataGallery();

        await axios.post('/saveGallery',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                gallery_errors.value = error.response.data.errors
            }
        });
    }
    /** END GALLERY **/

    /** START VIRTUAL TOUR **/
    async function getVirtualTours(){
        await axios.get('/getVirtualTours').then(response => {
            if(response.data.virtual_tours != null){
                virtual_tours.title            = response.data.virtual_tours.title
                virtual_tours.links           = (response.data.virtual_tours.links != null) ? response.data.virtual_tours.slidlinkses : []
                virtual_tours.links.forEach((link, index) => {
                    link.bg_img = link.bg
                    link.bg = null
                });
            }
        });
    }

    function setFormDataVirtualTours(){
        let formData = new FormData();

        if(virtual_tours.title !=null){
            formData.append('title', gallery.title);
        }
        
        if(virtual_tours.links != null && (virtual_tours.links.length > 0)){
            formData.append('links', JSON.stringify(virtual_tours.links));

            virtual_tours.links.forEach((link, index) => {
                if(link.bg != null && link.bg.name != null){
                    formData.append('link'+index.toString(), link.bg, link.bg.name);
                }else if(link.bg_img != null){
                    formData.append('existing_link'+index.toString(), link.bg_img);
                }
            });
        }
        
        return formData;
    }

    async function storeVirtualTours(){
        virtual_tours_errors.value = []

        let formData = setFormDataVirtualTours();

        await axios.post('/saveVirtualTours',formData
        ).then(response => {
            resetFields()
        }).catch(error => {
            if(error.response && error.response.status == 422){
                virtual_tours_errors.value = error.response.data.errors
            }
        });
    }
    /** END VIRTUAL TOUR **/

    return {
        main_banner,
        main_banner_errors,
        getMainBanner,
        storeMainBanner,
        overview,
        overview_errors,
        getOverview,
        storeOverview,
        main_categories,
        main_categories_errors,
        getMainCategories,
        storeMainCategories,
        carousel_sliders,
        carousel_sliders_errors,
        getCarouselSliders,
        storeCarouselSliders,
        features,
        features_errors,
        getFeatures,
        storeFeatures,
        about_us_errors,
        about_us,
        getAboutUs,
        storeAboutUs,
        gallery_swipers,
        gallery_swipers_errors,
        getGallerySwipers,
        storeGallerySwipers,
        brands,
        brands_errors,
        getBrands,
        storeBrands,
        footers,
        footers_errors,
        getFooters,
        storeFooters,
        gallery,
        gallery_errors,
        getGallery,
        storeGallery,
        virtual_tours,
        virtual_tours_errors,
        getVirtualTours,
        storeVirtualTours,
    }
}