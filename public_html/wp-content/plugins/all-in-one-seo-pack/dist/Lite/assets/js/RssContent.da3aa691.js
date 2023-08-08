import{e as S,u as b}from"./links.4e9269a4.js";import{C}from"./index.cd7fac8b.js";import{C as y}from"./Card.37225977.js";import{C as v}from"./HtmlTagsEditor.2a4955ac.js";import{C as R}from"./SettingsRow.2432af31.js";import{S as A}from"./External.95afe855.js";import{r as s,c as k,d as o,w as n,o as u,a as r,t as i,g as _,b as w,f as L}from"./vue.runtime.esm-bundler.1bf81f69.js";import{_ as $}from"./_plugin-vue_export-helper.4292a25a.js";import"./default-i18n.41786823.js";import"./isArrayLikeObject.76f0d098.js";import"./Caret.0b57d359.js";import"./Tooltip.fc81232d.js";import"./Slide.c4e68d01.js";import"./tags.9c0199b3.js";import"./Editor.87ec1d9f.js";import"./UnfilteredHtml.2d041b8c.js";import"./Row.1358a527.js";/* empty css                                            */const x={setup(){return{optionsStore:S(),rootStore:b()}},components:{CoreAlert:C,CoreCard:y,CoreHtmlTagsEditor:v,CoreSettingsRow:R,SvgExternal:A},data(){return{strings:{tooltip:this.$t.__("Automatically add content to your site's RSS feed.",this.$td),description:this.$t.__("This feature is used to automatically add content to your site's RSS feed. More specifically, it allows you to add links back to your blog and your blog posts so scrapers will automatically add these links too. This helps search engines identify you as the original source of the content.",this.$td),learnMore:this.$t.__("Learn more",this.$td),rssFeedDisabled:this.$t.sprintf(this.$t.__("Your RSS feed has been disabled. Disabling the global RSS feed is NOT recommended. This will prevent users from subscribing to your content and can hurt your SEO rankings. You can re-enable the global RSS feed in the %1$scrawl content settings%2$s.",this.$td),'<a href="'+this.rootStore.aioseo.urls.aio.searchAppearance+'&aioseo-scroll=crawl-content-global-feed&aioseo-highlight=crawl-content-global-feed#/advanced">',"</a>"),rssContent:this.$t.__("RSS Content Settings",this.$td),openYourRssFeed:this.$t.__("Open Your RSS Feed",this.$td),rssBeforeContent:this.$t.__("RSS Before Content",this.$td),rssAfterContent:this.$t.__("RSS After Content",this.$td),beforeRssDescription:this.$t.__("Add content before each post in your site feed.",this.$td),afterRssDescription:this.$t.__("Add content after each post in your site feed.",this.$td),unfilteredHtmlError:this.$t.sprintf(this.$t.__("Your user account role does not have access to edit this field. %1$s",this.$td),this.$links.getDocLink(this.$constants.GLOBAL_STRINGS.learnMore,"unfilteredHtml",!0))}}}},T={class:"aioseo-rss-content"},B={class:"aioseo-settings-row aioseo-section-description"},D=["innerHTML"],V={class:"aioseo-description"},H={class:"aioseo-description"};function M(l,a,N,e,t,O){const m=s("core-alert"),f=s("svg-external"),h=s("base-button"),c=s("core-settings-row"),p=s("core-html-tags-editor"),g=s("core-card");return u(),k("div",T,[o(g,{slug:"rssContent","header-text":t.strings.rssContent},{tooltip:n(()=>[r("div",null,i(t.strings.tooltip),1)]),default:n(()=>[r("div",B,[_(i(t.strings.description)+" ",1),r("span",{innerHTML:l.$links.getDocLink(l.$constants.GLOBAL_STRINGS.learnMore,"rssContent",!0)},null,8,D),e.optionsStore.options.searchAppearance.advanced.crawlCleanup.enable&&!e.optionsStore.options.searchAppearance.advanced.crawlCleanup.feeds.global?(u(),w(m,{key:0,type:"red",innerHTML:t.strings.rssFeedDisabled},null,8,["innerHTML"])):L("",!0)]),o(c,{name:l.$constants.GLOBAL_STRINGS.preview},{content:n(()=>[o(h,{size:"medium",type:"blue",tag:"a",href:e.rootStore.aioseo.urls.feeds.global,target:"_blank",disabled:e.optionsStore.options.searchAppearance.advanced.crawlCleanup.enable&&!e.optionsStore.options.searchAppearance.advanced.crawlCleanup.feeds.global},{default:n(()=>[o(f),_(" "+i(t.strings.openYourRssFeed),1)]),_:1},8,["href","disabled"])]),_:1},8,["name"]),o(c,{name:t.strings.rssBeforeContent},{content:n(()=>[o(p,{checkUnfilteredHtml:"",modelValue:e.optionsStore.options.rssContent.before,"onUpdate:modelValue":a[0]||(a[0]=d=>e.optionsStore.options.rssContent.before=d),"minimum-line-numbers":5,"tags-context":"rss","default-tags":["post_link","site_link","author_link"],disabled:e.optionsStore.options.searchAppearance.advanced.crawlCleanup.enable&&!e.optionsStore.options.searchAppearance.advanced.crawlCleanup.feeds.global},null,8,["modelValue","disabled"]),r("div",V,i(t.strings.beforeRssDescription),1)]),_:1},8,["name"]),o(c,{name:t.strings.rssAfterContent},{content:n(()=>[o(p,{checkUnfilteredHtml:"",modelValue:e.optionsStore.options.rssContent.after,"onUpdate:modelValue":a[1]||(a[1]=d=>e.optionsStore.options.rssContent.after=d),"minimum-line-numbers":5,"tags-context":"rss","default-tags":["post_link","site_link","author_link"],disabled:e.optionsStore.options.searchAppearance.advanced.crawlCleanup.enable&&!e.optionsStore.options.searchAppearance.advanced.crawlCleanup.feeds.global},null,8,["modelValue","disabled"]),r("div",H,i(t.strings.afterRssDescription),1)]),_:1},8,["name"])]),_:1},8,["header-text"])])}const oe=$(x,[["render",M]]);export{oe as default};
