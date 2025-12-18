/* =========================
   MintCash UI (Front-end فقط)
   ========================= */

const CONFIG = {
  appName: "منت كاش",
  pointsPerUsd: 1000, // 1000 نقطة = 1$
  withdrawMethods: [
    {
      id: "paypal",
      title_ar: "بايبال",
      title_en: "PayPal",
      enabled: true,
      requires: "email",
      input_label_ar: "أدخل بريد بايبال",
      input_placeholder: "example@email.com",
      sort: 50,
      amounts: [
        { usd: 2,  mc: 2000 },
        { usd: 5,  mc: 5000 },
        { usd: 10, mc: 10000 },
        { usd: 50, mc: 50000 },
      ],
    },
    {
      id: "google_play",
      title_ar: "جوجل بلاي",
      title_en: "Google Play",
      enabled: true,
      requires: "email",
      input_label_ar: "أدخل بريدك لاستلام كود جوجل بلاي",
      input_placeholder: "example@email.com",
      sort: 60,
      amounts: [
        { usd: 2,  mc: 2000 },
        { usd: 5,  mc: 5000 },
        { usd: 10, mc: 10000 },
        { usd: 50, mc: 50000 },
      ],
    },
  ],
  followTask: { id: "follow_channel", reward: 300 },
  dailyTasks: [
    { id: "offer_1", icon: "🎯", title: "مهمة عرض سريعة", sub: "نفّذ عرض مختار للحصول على نقاط", reward: 120 },
    { id: "survey_1", icon: "🧠", title: "استطلاع قصير", sub: "أجب على استطلاع لتحصل على نقاط", reward: 180 },
    { id: "game_1", icon: "🎮", title: "تجربة لعبة", sub: "جرّب لعبة لمدة دقيقة", reward: 90 },
  ],
  offers: [
    { id: "o1", icon: "📲", title: "تحميل تطبيق", sub: "ثبّت التطبيق وافتحه مرة", reward: 220, speed: "سريع" },
    { id: "o2", icon: "🕹️", title: "لعبة جديدة", sub: "العب 3 دقائق", reward: 300, speed: "مربح" },
    { id: "o3", icon: "🧾", title: "استطلاع مدفوع", sub: "استطلاع 2-4 دقائق", reward: 260, speed: "سريع" },
  ],
};

// ------- Storage -------
const STORE_KEY = "mintcash_ui_v1";
const defaultState = {
  user: { name: "زائر", email: "", loggedIn: false },
  points: 0,
  level: 1,
  completed: {}, // taskId: true
  withdrawRequests: [], // local only
  referralCode: null,
};

function loadState(){
  try{
    const raw = localStorage.getItem(STORE_KEY);
    if(!raw) return structuredClone(defaultState);
    const s = JSON.parse(raw);
    return { ...structuredClone(defaultState), ...s };
  }catch{
    return structuredClone(defaultState);
  }
}
function saveState(){
  localStorage.setItem(STORE_KEY, JSON.stringify(state));
}

let state = loadState();

// ------- Helpers -------
const $ = (q) => document.querySelector(q);
const $$ = (q) => [...document.querySelectorAll(q)];

function toast(msg){
  const t = $("#toast");
  t.textContent = msg;
  t.classList.add("show");
  clearTimeout(toast._t);
  toast._t = setTimeout(()=> t.classList.remove("show"), 1800);
}

function fmt(n){
  return new Intl.NumberFormat("ar").format(n);
}

function ensureReferralCode(){
  if(state.referralCode) return state.referralCode;
  const code = Math.random().toString(36).slice(2,8).toUpperCase();
  state.referralCode = code;
  saveState();
  return code;
}

function setActivePage(key){
  const map = {
    home: "#page-home",
    earn: "#page-earn",
    offers: "#page-offers",
    withdraw: "#page-withdraw",
    referrals: "#page-referrals",
    how: "#page-how",
    auth: "#page-auth",
  };
  const sel = map[key] || map.home;

  $$(".page").forEach(p => p.classList.remove("active"));
  $(sel).classList.add("active");

  $$(".navItem").forEach(b => b.classList.toggle("active", b.dataset.nav === key));
  // إذا كانت صفحة ليست ضمن navbar (how/auth) نخلي active حسب الأقرب
  if(key === "how" || key === "auth"){
    $$(".navItem").forEach(b => b.classList.remove("active"));
  }
  window.scrollTo({top:0, behavior:"smooth"});
}

function updateHeaderAuthBtn(){
  const btn = $("#btnAuth");
  btn.textContent = state.user.loggedIn ? "حسابي" : "تسجيل / إنشاء";
}

function updateUserUI(){
  $("#uName").textContent = state.user.loggedIn ? state.user.name : "زائر";
  $("#uPoints").textContent = fmt(state.points);
  $("#uLevel").textContent = `المستوى: ${state.level}`;
  $("#uRate").textContent = `${fmt(CONFIG.pointsPerUsd)} نقطة = 1 دولار`;
  $("#followReward").textContent = fmt(CONFIG.followTask.reward);
  updateHeaderAuthBtn();

  // referral link
  const code = ensureReferralCode();
  const base = window.location.origin + window.location.pathname.replace(/\/[^/]*$/, "/");
  $("#refLink").value = `${base}?ref=${encodeURIComponent(code)}`;

  // withdraw requests
  renderWithdrawRequests();
}

// ------- Render: Tasks -------
function renderDailyTasks(){
  const wrap = $("#tasksList");
  wrap.innerHTML = "";

  CONFIG.dailyTasks.forEach(t => {
    const done = !!state.completed[t.id];
    const el = document.createElement("div");
    el.className = "card tItem";
    el.innerHTML = `
      <div class="tIcon">${t.icon}</div>
      <div class="tBody">
        <div class="tTitle">${t.title}</div>
        <div class="tSub">${t.sub}</div>
      </div>
      <div class="tRight">
        <div class="badge">+ ${fmt(t.reward)} نقطة</div>
        <button class="btn small ${done ? "ghost" : ""}" data-task="${t.id}">
          ${done ? "تم" : "تنفيذ"}
        </button>
      </div>
    `;
    wrap.appendChild(el);

    const btn = el.querySelector("button");
    btn.addEventListener("click", ()=>{
      if(done) return toast("هذه المهمة تم تنفيذها مسبقًا");
      // UI فقط: نضيف نقاط مباشرة
      state.completed[t.id] = true;
      state.points += t.reward;
      bumpLevelIfNeeded();
      saveState();
      updateUserUI();
      renderDailyTasks();
      toast(`تمت إضافة ${fmt(t.reward)} نقطة`);
    });
  });
}

function bumpLevelIfNeeded(){
  // نظام بسيط: كل 5000 نقطة = مستوى +1
  const lvl = 1 + Math.floor(state.points / 5000);
  state.level = Math.max(1, lvl);
}

// ------- Render: Offers -------
function renderOffers(){
  const wrap = $("#offersGrid");
  wrap.innerHTML = "";
  CONFIG.offers.forEach(o=>{
    const el = document.createElement("div");
    el.className = "card offer";
    el.innerHTML = `
      <div class="offerLeft">
        <div class="offerIcon">${o.icon}</div>
        <div>
          <div class="offerTitle">${o.title}</div>
          <div class="offerSub">${o.sub}</div>
        </div>
      </div>
      <div class="offerRight">
        <div class="badge">${o.speed}</div>
        <button class="btn small" data-offer="${o.id}">ابدأ</button>
        <div class="muted" style="font-size:12px">+ ${fmt(o.reward)} نقطة</div>
      </div>
    `;
    wrap.appendChild(el);

    el.querySelector("button").addEventListener("click", ()=>{
      toast("واجهة فقط الآن — ربط شركات الإعلانات لاحقًا");
      // كمثال: نعطي نقاط بعد "بدء"
      state.points += o.reward;
      bumpLevelIfNeeded();
      saveState();
      updateUserUI();
      toast(`تمت إضافة ${fmt(o.reward)} نقطة بعد التحقق`);
    });
  });
}

// ------- Withdraw UI -------
function getEnabledMethods(){
  return CONFIG.withdrawMethods
    .filter(m => m.enabled)
    .sort((a,b)=> (a.sort||0) - (b.sort||0));
}

function fillWithdrawMethods(){
  const sel = $("#withdrawMethod");
  sel.innerHTML = "";
  getEnabledMethods().forEach(m=>{
    const opt = document.createElement("option");
    opt.value = m.id;
    opt.textContent = m.title_ar;
    sel.appendChild(opt);
  });
}

function fillWithdrawUsd(){
  const methodId = $("#withdrawMethod").value;
  const m = getEnabledMethods().find(x=>x.id===methodId);
  const sel = $("#withdrawUsd");
  sel.innerHTML = "";

  (m?.amounts || []).forEach(a=>{
    const opt = document.createElement("option");
    opt.value = String(a.usd);
    opt.textContent = `${a.usd}$`;
    sel.appendChild(opt);
  });

  // set target labels
  $("#targetLabel").textContent = m?.input_label_ar || "البيانات";
  $("#withdrawTarget").placeholder = m?.input_placeholder || "";

  updateWithdrawPoints();
}

function updateWithdrawPoints(){
  const methodId = $("#withdrawMethod").value;
  const usd = Number($("#withdrawUsd").value || 0);
  const m = getEnabledMethods().find(x=>x.id===methodId);
  const a = (m?.amounts || []).find(x=>x.usd===usd);
  const points = a ? a.mc : (usd * CONFIG.pointsPerUsd);
  $("#withdrawPoints").textContent = fmt(points);
}

function renderWithdrawLimits(){
  const ul = $("#withdrawLimitsList");
  ul.innerHTML = "";
  getEnabledMethods().forEach(m=>{
    (m.amounts||[]).forEach(a=>{
      const li = document.createElement("li");
      li.textContent = `${m.title_ar}: ${a.usd}$ = ${fmt(a.mc)} نقطة`;
      ul.appendChild(li);
    });
  });
}

function createWithdrawRequest(){
  const methodId = $("#withdrawMethod").value;
  const usd = Number($("#withdrawUsd").value || 0);
  const target = ($("#withdrawTarget").value || "").trim();

  const m = getEnabledMethods().find(x=>x.id===methodId);
  const a = (m?.amounts || []).find(x=>x.usd===usd);
  const needed = a ? a.mc : (usd * CONFIG.pointsPerUsd);

  if(!target){
    return toast("اكتب البيانات المطلوبة للطريقة المختارة");
  }
  if(state.points < needed){
    return toast("رصيدك غير كافي لهذا السحب");
  }

  // UI فقط: نسجل طلب محلي ونخصم النقاط
  state.points -= needed;
  bumpLevelIfNeeded();

  const req = {
    id: "REQ_" + Date.now(),
    user_id: state.user.loggedIn ? "UID_LOCAL" : "UID_GUEST",
    method: methodId,
    amount_usd: usd,
    amount_mc: needed,
    target,
    status: "pending",
    created_at: new Date().toISOString(),
    updated_at: new Date().toISOString(),
  };
  state.withdrawRequests.unshift(req);
  saveState();
  updateUserUI();
  toast("تم إرسال طلب السحب (قيد المراجعة)");
}

function renderWithdrawRequests(){
  const wrap = $("#withdrawRequests");
  wrap.innerHTML = "";
  const list = state.withdrawRequests || [];
  if(!list.length){
    wrap.innerHTML = `<div class="muted">لا يوجد طلبات بعد.</div>`;
    return;
  }
  list.slice(0,20).forEach(r=>{
    const m = CONFIG.withdrawMethods.find(x=>x.id===r.method);
    const el = document.createElement("div");
    el.className = "req";
    el.innerHTML = `
      <div class="reqRow">
        <div><strong>${m?.title_ar || r.method}</strong> — ${r.amount_usd}$</div>
        <div class="reqStatus">pending</div>
      </div>
      <div class="reqMeta">${fmt(r.amount_mc)} نقطة • ${r.target}</div>
      <div class="reqMeta">تاريخ: ${new Date(r.created_at).toLocaleString("ar")}</div>
    `;
    wrap.appendChild(el);
  });
}

// ------- Auth (local only) -------
function login(){
  const name = ($("#authName").value || "").trim();
  const email = ($("#authEmail").value || "").trim();
  if(!name) return toast("اكتب اسمك");
  state.user = { name, email, loggedIn: true };
  saveState();
  updateUserUI();
  toast("تم الدخول");
  setActivePage("earn");
}
function logout(){
  state.user = { name: "زائر", email: "", loggedIn: false };
  saveState();
  updateUserUI();
  toast("تم تسجيل الخروج");
}

// ------- Events -------
function wireNav(){
  $$(".navItem").forEach(b=>{
    b.addEventListener("click", ()=> setActivePage(b.dataset.nav));
  });
  $$("[data-nav]").forEach(b=>{
    b.addEventListener("click", ()=> setActivePage(b.dataset.nav));
  });

  $("#btnOpenEarnings").addEventListener("click", ()=> setActivePage("earn"));
  $("#btnAuth").addEventListener("click", ()=> setActivePage("auth"));

  $("#btnCopyRef").addEventListener("click", async ()=>{
    try{
      await navigator.clipboard.writeText($("#refLink").value);
      toast("تم نسخ رابط الدعوة");
    }catch{
      toast("انسخ الرابط يدويًا");
    }
  });

  $("#btnFollow").addEventListener("click", ()=>{
    const id = CONFIG.followTask.id;
    if(state.completed[id]) return toast("تم تنفيذها مسبقًا");
    state.completed[id] = true;
    state.points += CONFIG.followTask.reward;
    bumpLevelIfNeeded();
    saveState();
    updateUserUI();
    renderDailyTasks();
    toast(`تمت إضافة ${fmt(CONFIG.followTask.reward)} نقطة`);
  });

  $("#withdrawMethod").addEventListener("change", fillWithdrawUsd);
  $("#withdrawUsd").addEventListener("change", updateWithdrawPoints);
  $("#btnCreateWithdraw").addEventListener("click", createWithdrawRequest);

  $("#btnLogin").addEventListener("click", login);
  $("#btnLogout").addEventListener("click", logout);
}

// ------- Init -------
function init(){
  // ref capture
  const url = new URL(window.location.href);
  const ref = url.searchParams.get("ref");
  if(ref && !state._refCaptured){
    state._refCaptured = ref;
    saveState();
  }

  fillWithdrawMethods();
  fillWithdrawUsd();
  renderWithdrawLimits();
  renderDailyTasks();
  renderOffers();

  updateUserUI();
  wireNav();

  // Default page
  setActivePage("home");
}

init();