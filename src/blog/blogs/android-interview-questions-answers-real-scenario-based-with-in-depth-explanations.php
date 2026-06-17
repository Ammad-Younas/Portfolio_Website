<?php
require_once dirname(__DIR__, 3) . '/includes/functions.php';

$blog_data = [
    'meta' => [
        'title' => 'Android Interview Questions & Answers : Real Scenario Based with In-Depth Explanations',
        'subtitle' => 'A deep, easy-to-understand interview preparation guide for Android developers explained the way a senior engineer would explain it to you…',
        'published' => '2026-06-12',
        'tags' => ['Android', 'Kotlin', 'Jetpack Compose', 'Android Interviews', 'Programming']
    ],
    'qna' => [
        [
            'question' => "Q1. A user is filling a long form. They rotate the screen and everything they typed disappears. What happened, and how do you fix it?",
            'answer' => "When you rotate the screen, Android **destroys and recreates the Activity**. This is a _configuration change_. The system thinks: \"The screen is now different (landscape), so I should rebuild the UI from scratch.\" During this rebuild, any data held only in memory (like local variables) is lost.\n\nThe text in EditText fields is usually saved automatically because views with an `id` save their own state. But your _custom_ variables are not.\n\n**The fix depends on the type of data:**\n\n- For small, temporary UI state, use `onSaveInstanceState(Bundle)` to save it and restore it in `onCreate` or `onRestoreInstanceState`.\n- The modern, recommended fix is a **ViewModel**. A ViewModel survives configuration changes because it is scoped to the Activity's lifecycle, not destroyed on rotation. So you keep form data in the ViewModel, and after rotation the recreated Activity gets the _same_ ViewModel instance back.\n- For process death (system killing your app in the background), even ViewModel is lost, so combine ViewModel with `SavedStateHandle` to survive both cases.\n\n**Senior-level point:** Always distinguish between _configuration change_ (rotation — ViewModel saves you) and _process death_ (system reclaims memory — only persisted/SavedStateHandle data survives). Saying this shows real understanding."
        ],
        [
            'question' => "Q2. Walk me through the Activity lifecycle, and tell me which method runs first when a phone call interrupts the app.",
            'answer' => "Think of an Activity as a screen that moves through stages of \"alive.\"\n\n- **onCreate()** — The screen is being born. You set up the UI and initialize things here. Runs once.\n- **onStart()** — The screen becomes visible but you cannot interact yet.\n- **onResume()** — The screen is now in the foreground and interactive. The user is actively using it.\n- **onPause()** — Something is partially covering the screen (a dialog, an incoming call). The Activity is still partly visible. This runs **first** when interrupted.\n- **onStop()** — The screen is fully hidden (user pressed Home, or another Activity covers it completely).\n- **onDestroy()** — The screen is being removed from memory.\n\n**When a phone call comes in:** the app goes to `onPause()` first (call screen partially appears), and if the call screen fully covers the app, then `onStop()`. When the call ends and you return, it goes `onStart()` → `onResume()`.\n\n**Key rule for interviews:** Do heavy work in `onCreate`, release things that should not run in the background in `onPause`/`onStop` (like the camera or location updates), and never do long blocking work in any lifecycle method because they run on the main thread."
        ],
        [
            'question' => "Q3. Your app saves user notes in onPause(). A tester says notes are sometimes lost. Why, and where should you actually save?",
            'answer' => "`onPause()` is _not_ guaranteed to be the last call before your app is killed, and it must be **fast** because the next screen cannot fully appear until `onPause` finishes. If you do slow disk writes here, you block the UI transition.\n\nThe real issue: in older thinking people treated `onPause` as \"safe to save.\" But the system can kill your process after `onStop` without calling `onDestroy`. And `onPause` runs even for a quick dialog, causing unnecessary writes.\n\n**Better approach:**\n\n- Save _critical_ data as the user types or as changes happen (auto-save with debounce), not all at once in a lifecycle method.\n- For draft/important state, persist to a database or DataStore on a background thread.\n- Use `onStop()` rather than `onPause()` for \"user is leaving\" saves, because `onStop` means the screen is truly hidden, and keep the write off the main thread.\n\n**Senior point:** Lifecycle methods are _signals_, not _guarantees of finishing work_. Never put long-running writes directly inside them."
        ],
        [
            'question' => "Q4. What is the difference between onCreate(), onStart(), and onResume()? Give a real reason you'd use each.",
            'answer' => "- **onCreate()** — Use it for one-time setup: inflate the layout, bind the ViewModel, set up RecyclerView adapters. It runs once per Activity creation.\n- **onStart()** — Use it to start things that should only run while visible, like registering a broadcast receiver or starting location updates. It can run multiple times (every time the app comes back into view).\n- **onResume()** — Use it for things that need the screen to be in the _foreground and interactive_, like resuming a camera preview, starting animations, or refreshing data that must be current the moment the user looks at it.\n\n**The pairing rule interviewers love:** Whatever you start in `onStart`, stop in `onStop`. Whatever you start in `onResume`, pause in `onPause`. This symmetry prevents leaks and battery drain."
        ],
        [
            'question' => "Q5. What is the Application class, and when would you genuinely need it?",
            'answer' => "The `Application` class is a single object created **once** when your app process starts and lives as long as the process lives. It exists before any Activity.\n\nYou need it (or extend it) when you must initialize something **globally and early**, such as:\n\n- Dependency injection setup (Hilt requires `@HiltAndroidApp` on the Application class).\n- Crash reporting / analytics SDK initialization.\n- Setting up a logging library.\n\n**Common mistake interviewers probe:** People store data in the Application class to share it between screens. That is an anti-pattern — it becomes a global mutable state that leaks and is hard to test. Use proper scoped storage (Repository, database, DI) instead. Mention this and you stand out."
        ],
        [
            'question' => "Q6. Explain the four Android components and give a real-world example of each.",
            'answer' => "1. **Activity** — A single screen the user sees. Example: the login screen.\n2. **Service** — A component that runs in the background without UI. Example: a music player that keeps playing when you leave the app. (Modern Android prefers WorkManager/foreground services for most cases.)\n3. **BroadcastReceiver** — Listens for system-wide or app events. Example: detecting when the device finishes booting, or when connectivity changes.\n4. **ContentProvider** — Shares data between apps in a structured way. Example: accessing the device's contacts or photos.\n\n**Why they matter:** All four (except some implicit cases now) must be declared in the **AndroidManifest.xml**, and they are the \"entry points\" through which Android and other apps can start parts of your app."
        ],
        [
            'question' => "Q7. What is the AndroidManifest.xml and what breaks if you forget to declare something in it?",
            'answer' => "The manifest is the app's **identity card and rulebook**. It tells the Android system:\n\n- The app's package name and components (activities, services, receivers, providers).\n- Permissions the app needs (camera, internet, location).\n- Hardware/software requirements and minimum SDK.\n- Which Activity is the launcher (the one that opens when you tap the icon).\n\n**What breaks:**\n\n- Forget to declare an Activity → app crashes with `ActivityNotFoundException` when you try to open it.\n- Forget the `INTERNET` permission → all network calls silently fail.\n- Forget a runtime-permission declaration → you cannot even request that permission at runtime."
        ],
        [
            'question' => "Q8. The interviewer says: \"My app shows a blank white screen for a second before launching. Why?\"",
            'answer' => "That white screen is the **default launch (starting) window** that the system shows while your app's process is being created and your first Activity is loading. If your `Application.onCreate()` or first Activity does heavy work on the main thread, this delay gets longer.\n\n**Causes and fixes:**\n\n- Heavy initialization in `Application` class → move non-essential init off the startup path; lazy-initialize.\n- Doing disk/network work synchronously on launch → defer it.\n- Use the **Android 12+ SplashScreen API** to show a proper branded splash instead of a blank window, and use App Startup library to organize initialization order.\n\n**Senior point:** Use `cold start` vs `warm start` vocabulary. A cold start (process not alive) is the slow one; optimizing it is about reducing main-thread work before the first frame."
        ],
        [
            'question' => "Q9. What is the difference between an explicit Intent and an implicit Intent? When do you use each?",
            'answer' => "An **Intent** is a message that says \"do this action\" or \"open this screen.\"\n\n- **Explicit Intent** names the exact component to start. Example: `Intent(this, ProfileActivity::class.java)`. Use it to move between screens inside your own app.\n- **Implicit Intent** describes an _action_ and lets the system find an app that can handle it. Example: \"open this URL\" or \"share this text.\" The system shows a chooser (browser, share sheet, etc.).\n\n**Real scenario:** \"User taps a phone number and it should open the dialer\" → implicit Intent with `ACTION_DIAL`. \"User taps a list item to see details\" → explicit Intent to your DetailActivity."
        ],
        [
            'question' => "Q10. What is a Bundle and why not just use a global variable to pass data between screens?",
            'answer' => "A **Bundle** is a key-value container used to pass small amounts of data between components (Activities, Fragments). It works because its contents can be serialized (turned into bytes), which is required when the system needs to recreate or transport your component across process boundaries.\n\n**Why not a global variable / static field:**\n\n- Globals survive longer than they should, causing **memory leaks**.\n- They do not survive **process death** — if the system kills and restarts your app, a global is empty, but a Bundle saved in `onSaveInstanceState` is restored.\n- Globals make code untestable and create hidden dependencies.\n\n**Rule:** Pass _identifiers_ (like a user ID) through Bundles/arguments, then load the full data from a repository — don't pass huge objects around."
        ],
        [
            'question' => "Q11. What is `setContentView()` actually doing under the hood?",
            'answer' => "`setContentView()` takes your XML layout, runs the **LayoutInflater** which reads the XML and creates the corresponding View objects in memory (a tree of Views), and attaches that tree to the Activity's root view (the DecorView's content frame).\n\nSo XML is just a blueprint; inflation is the construction process that turns it into real objects you can manipulate. Inflation is **not free** — deeply nested layouts cost more to inflate, which is why flat layouts (ConstraintLayout) render faster."
        ],
        [
            'question' => "Q12. The system killed your app while it was in the background and the user lost their place. How do you handle this gracefully?",
            'answer' => "This is **process death**. When the system needs memory, it can kill background app processes. The user expects to return to the same place (\"state restoration\").\n\n**Handle it with layers:**\n\n1. **SavedStateHandle / onSaveInstanceState** — restore transient UI state (scroll position, selected tab, entered text).\n2. **Persistent storage (Room/DataStore)** — anything that truly must not be lost (a draft order, form data) should be written to disk, not just kept in memory.\n3. **Navigation state** — Jetpack Navigation can restore the back stack so the user lands on the right screen.\n\n**Senior point:** Test this deliberately using \"Don't keep activities\" in Developer Options, or by terminating the process from Android Studio. Most bugs here are invisible until you force-test process death."
        ],
        [
            'question' => "Q13. When would you use a Fragment instead of an Activity? Give a real product reason.",
            'answer' => "A **Fragment** is a reusable, modular piece of UI that lives _inside_ an Activity. Use Fragments when:\n\n- You want **one Activity hosting many screens** (the modern single-Activity architecture), which makes navigation and shared state easier.\n- You need **different layouts for tablets vs phones** (two fragments side-by-side on a tablet, one at a time on a phone).\n- You want to **reuse a UI block** across multiple screens.\n\n**Real reason:** A news app shows a list and a detail. On a phone, tapping the list opens the detail full-screen. On a tablet, list and detail show together. Fragments make this responsive layout possible without rewriting screens."
        ],
        [
            'question' => "Q14. Two fragments need to talk to each other. How do you do it the right way?",
            'answer' => "Fragments should **never directly reference each other** — that creates tight coupling and crashes when one is not attached.\n\n**The correct way:** share data through a **shared ViewModel** scoped to the parent Activity (or the navigation graph). Fragment A writes to the ViewModel; Fragment B observes it via LiveData/StateFlow. Neither knows the other exists.\n\nFor one-off results (like a dialog returning a value), use the **Fragment Result API** (`setFragmentResult` / `setFragmentResultListener`).\n\n**Why this matters:** Direct fragment-to-fragment calls break the moment the lifecycle changes. The shared-ViewModel pattern is lifecycle-safe and testable."
        ],
        [
            'question' => "Q15. What is the Fragment lifecycle's relationship with its View, and why does this cause memory leaks?",
            'answer' => "A Fragment has **two lifecycles**: the Fragment itself, and its **View**. The View can be destroyed (`onDestroyView`) while the Fragment object still lives — for example when the fragment goes onto the back stack.\n\n**The leak:** If you hold a reference to a View (or binding) in a Fragment-level variable and don't clear it in `onDestroyView`, the old destroyed View stays in memory. With ViewBinding, the classic fix is:\n\n```kotlin\nprivate var _binding: FragmentHomeBinding? = null\nprivate val binding get() = _binding!!\n\noverride fun onDestroyView() {\n    super.onDestroyView()\n    _binding = null   // release the view\n}\n```\n\nAlso, when observing LiveData in a Fragment, use `viewLifecycleOwner`, not `this`, otherwise observers can fire after the View is gone and crash."
        ],
        [
            'question' => "Q16. Explain the back stack with a real navigation example.",
            'answer' => "The **back stack** is a pile of screens. Each new screen goes on **top**; pressing Back **pops** the top one off, revealing the screen beneath.\n\n**Example:** Home → Product List → Product Detail. The stack (bottom to top) is [Home, List, Detail]. Press Back → Detail pops → you see List. Press Back again → List pops → you see Home.\n\n**Tricky interview part:** Sometimes you don't want a screen on the back stack. After a successful login, you don't want Back to return to the login screen. You handle this with `popUpTo` (clearing the login destination) in Navigation, or `FLAG_ACTIVITY_CLEAR_TASK` with Intents."
        ],
        [
            'question' => "Q17. What is the Jetpack Navigation component and what real problem does it solve?",
            'answer' => "Before Navigation, moving between screens meant scattered `startActivity`/`FragmentTransaction` code, manual back-stack handling, and error-prone argument passing. **Jetpack Navigation** centralizes all of this into a **navigation graph** — a single visual map of your screens and the routes between them.\n\n**Problems it solves:**\n\n- **Type-safe arguments** with Safe Args (no more string-key typos).\n- **Consistent back-stack** handling.\n- **Deep links** handled in one place.\n- Easier single-Activity architecture."
        ],
        [
            'question' => "Q18. A user taps a notification and should land on a specific screen deep inside the app. How?",
            'answer' => "This is a **deep link**. You define the destination and its path in the navigation graph (or manifest), and the system/Navigation builds the correct **back stack** so that pressing Back behaves naturally (the user can navigate \"up\" as if they'd reached the screen normally).\n\n**Two types:**\n\n- **Explicit deep link** — built in code, often via a `PendingIntent` attached to a notification.\n- **Implicit deep link** — a URL (`https://myapp.com/product/42`) that opens the app at the right screen.\n\n**Senior point:** The hard part is **synthesizing the back stack** so the user isn't trapped on the deep-linked screen with nowhere to go back to. Jetpack Navigation does this for you."
        ],
        [
            'question' => "Q19. What is a PendingIntent and why is it called \"pending\"?",
            'answer' => "A **PendingIntent** is a token you give to _another app or the system_ that lets it execute an Intent **on your behalf, later, with your app's permissions**. It's \"pending\" because the action happens in the future, triggered by something outside your app — like the user tapping a notification or an alarm firing.\n\n**Real use:** Notifications, alarms (AlarmManager), and widgets all need PendingIntents because they fire when your app may not even be running.\n\n**Security note (Android 12+):** You must specify mutability (`FLAG_IMMUTABLE` or `FLAG_MUTABLE`). Use `FLAG_IMMUTABLE` unless you specifically need the receiver to fill in data, because mutable PendingIntents are a security risk."
        ],
        [
            'question' => "Q20. launchMode \"singleTop\" vs \"singleTask\" — explain with a scenario.",
            'answer' => "These control how Activities are reused in the back stack.\n\n- **standard** (default) — a new instance every time, even duplicates.\n- **singleTop** — if an instance is **already on top**, reuse it (calls `onNewIntent`) instead of creating a new one. Scenario: a search screen where the user searches again — you don't want a stack of identical search screens piling up.\n- **singleTask** — only **one instance exists in the whole task**; navigating to it clears everything above it. Scenario: a \"Home\" screen you always want to return to as the single root.\n- **singleInstance** — like singleTask but the Activity lives alone in its own task. Rare; used for special launcher-like screens."
        ],
        [
            'question' => "Q21. What's the difference between `finish()` and pressing the Back button?",
            'answer' => "Both remove the current Activity, but:\n\n- **Back button** is user-driven and follows the normal back-stack behavior; it can be intercepted (`onBackPressed` / the new `OnBackPressedDispatcher`).\n- **finish()** is you, the developer, programmatically closing the Activity — for example after a form is submitted, or to skip a screen on Back.\n\n**Modern note:** Use the `OnBackPressedDispatcher` / predictive back gesture APIs instead of overriding `onBackPressed`, which is deprecated. Mentioning predictive back (Android 13+/14) shows you're current."
        ],
        [
            'question' => "Q22. Why is \"single Activity, many Fragments/Composables\" considered modern best practice?",
            'answer' => "Because it gives you:\n\n- **One source of truth** for navigation (one nav graph), instead of juggling Activity-to-Activity transitions and Intents.\n- **Easier shared state** via Activity-scoped ViewModels.\n- **Smoother transitions and animations** between screens.\n- Better fit with Jetpack Navigation and Compose.\n\nMultiple Activities still make sense for genuinely separate \"tasks\" (e.g., a standalone checkout flow), but for in-app navigation, a single Activity is cleaner and less leak-prone."
        ],
        [
            'question' => "Q23. Your scrolling list (RecyclerView) is laggy and stutters. Walk me through how you'd fix it.",
            'answer' => "Lag in a list almost always means **work is happening on the main thread during scroll**, or views are being recreated unnecessarily.\n\n**Systematic fixes:**\n\n1. **Are you using RecyclerView with a ViewHolder correctly?** The whole point of RecyclerView is to _recycle_ a small number of views and rebind data. If you accidentally inflate views in `onBindViewHolder`, you've defeated it.\n2. **Heavy work in onBindViewHolder** — binding should be cheap. No image decoding, no database calls, no formatting heavy strings there. Pre-process data before it reaches the adapter.\n3. **Image loading** — use Glide/Coil which load and cache images off the main thread and into the right size. Loading full-resolution images into small cells kills performance.\n4. **Use DiffUtil / ListAdapter** so only changed items are redrawn instead of the whole list.\n5. **Flatten item layouts** — nested LinearLayouts are expensive; use ConstraintLayout or simpler hierarchies.\n6. **Profile with the GPU rendering / Layout Inspector / Systrace (Perfetto)** to find the exact slow frame.\n\n**Senior point:** Mention \"overdraw\" (drawing the same pixel multiple times) and \"jank\" (frames taking longer than ~16ms at 60fps). These words signal you've done real performance work."
        ],
        [
            'question' => "Q24. What is a ViewHolder and what real problem does it solve?",
            'answer' => "Old ListView called `findViewById` for every row, every time it scrolled — extremely wasteful. The **ViewHolder pattern** caches the view references for a row in an object so they're looked up **once** and reused as the row is recycled.\n\nRecyclerView **enforces** the ViewHolder pattern. As you scroll, off-screen rows are recycled: their ViewHolder is rebound with new data instead of being recreated. This is why RecyclerView smoothly handles thousands of items."
        ],
        [
            'question' => "Q25. What is DiffUtil and why does it matter for the user?",
            'answer' => "When your list data changes, refreshing the _entire_ list with `notifyDataSetChanged()` is wasteful and causes flicker and lost scroll position. **DiffUtil** calculates the **minimal set of changes** between the old list and the new list, so only the items that actually changed are animated and redrawn.\n\n**For the user:** smooth animations (an item slides in, one updates) instead of the whole screen flashing. **For performance:** far less work on the main thread.\n\n`ListAdapter` wraps DiffUtil so you just call `submitList(newList)` and it figures out the diff for you (often on a background thread)."
        ],
        [
            'question' => "Q26. Explain the three phases of how a View is drawn: measure, layout, draw.",
            'answer' => "Every frame, Android renders the view tree in three passes:\n\n1. **Measure** — each view figures out how big it wants to be, considering constraints from its parent.\n2. **Layout** — each view is positioned (its x/y coordinates) within its parent.\n3. **Draw** — each view paints itself onto the screen.\n\n**Why it matters:** Deeply nested layouts cause **multiple measure passes** (especially with nested weights in LinearLayout), which is slow. ConstraintLayout flattens the hierarchy so the measure/layout work is cheaper. This is the core reason \"flat is fast.\""
        ],
        [
            'question' => "Q27. ConstraintLayout vs LinearLayout vs RelativeLayout — when does each make sense?",
            'answer' => "- **LinearLayout** — arranges children in a single row or column. Great for simple stacks. But nested LinearLayouts with weights are a performance trap.\n- **RelativeLayout** — positions children relative to each other or the parent. Largely superseded by ConstraintLayout.\n- **ConstraintLayout** — positions children using constraints (anchors) to other views and guidelines. It lets you build **complex, flat layouts** without nesting, which is faster to render and easier to make responsive.\n\n**Rule of thumb:** Use LinearLayout for trivially simple stacks, ConstraintLayout for anything moderately complex. Avoid deep nesting either way."
        ],
        [
            'question' => "Q28. What is Jetpack Compose, and how is it fundamentally different from the XML View system?",
            'answer' => "The old system is **imperative**: you build a View tree in XML, then _manually mutate_ it (`textView.text = \"...\"`) whenever data changes. You're responsible for keeping the UI in sync with data, which is error-prone.\n\n**Jetpack Compose is declarative**: you write functions that _describe_ what the UI should look like **for a given state**. When the state changes, Compose **re-runs** the relevant functions and updates only what changed. You never manually mutate views — you just change the state and the UI follows.\n\n**Analogy:** Imperative is like giving turn-by-turn directions and updating them constantly. Declarative is like giving a destination address — describe the end result, and the framework figures out how to get there."
        ],
        [
            'question' => "Q29. What is \"recomposition\" in Compose and why can it hurt performance if you're careless?",
            'answer' => "**Recomposition** is Compose re-running a composable function because the state it reads has changed. This is normal and how the UI stays up to date.\n\n**The danger:** If you read a frequently-changing state high in your UI tree, you can cause **large or repeated recompositions**, redrawing more than necessary. Also, doing work (like sorting a list or heavy calculation) _directly inside_ a composable means it re-runs on every recomposition.\n\n**Fixes:**\n\n- Use `remember` to cache expensive calculations across recompositions.\n- Use `derivedStateOf` for state computed from other state.\n- Keep state as **low** in the tree as possible (state hoisting done thoughtfully) so fewer composables recompose.\n- Make sure your data classes are **stable** so Compose can skip unchanged composables."
        ],
        [
            'question' => "Q30. Explain `remember` vs `rememberSaveable` with a scenario.",
            'answer' => "- **remember** — caches a value across **recompositions**. But it is **lost on configuration change** (rotation) because the composable is recreated.\n- **rememberSaveable** — caches across recompositions **and** survives configuration changes and process death (it saves into a Bundle internally).\n\n**Scenario:** A counter on screen. `remember` keeps it during recomposition but resets to 0 on rotation. `rememberSaveable` keeps the count even after rotation. So for UI state the user would be annoyed to lose, use `rememberSaveable`."
        ],
        [
            'question' => "Q31. What is state hoisting in Compose and why do interviewers love it?",
            'answer' => "**State hoisting** means moving state _up_ out of a composable so the composable becomes **stateless** — it just receives the value and a callback to change it. The parent owns the state.\n\n```kotlin\n@Composable\nfun Counter(count: Int, onIncrement: () -> Unit) {\n    Button(onClick = onIncrement) { Text(\"Count: \$count\") }\n}\n```\n\n**Why it matters:**\n\n- The composable becomes **reusable** (works with any state source).\n- It becomes **testable** (you control inputs).\n- It creates a **single source of truth** (the parent/ViewModel owns state), avoiding bugs where two places disagree about the value.\n\nThis pattern (\"state down, events up\") is the heart of good Compose architecture."
        ],
        [
            'question' => "Q32. In Compose, how do you run a one-time action like showing a Snackbar or starting an animation when a screen appears?",
            'answer' => "You use a **side-effect API**, because you must not do non-UI work directly in the composable body (it can re-run many times).\n\n- **LaunchedEffect(key)** — runs a coroutine when the composable enters the composition (and restarts if the key changes). Perfect for \"load data once\" or \"show a snackbar when an error state appears.\"\n- **DisposableEffect** — for setup that needs **cleanup** (register a listener, then unregister on leave).\n- **rememberCoroutineScope** — to launch coroutines in response to _user events_ (like a button click), not composition.\n\n**Why:** these guarantee the effect runs at the right lifecycle moment and doesn't fire on every recomposition."
        ],
        [
            'question' => "Q33. How does Compose talk to ViewModel and observe data?",
            'answer' => "The ViewModel exposes state as **StateFlow** (or `mutableStateOf`). In the composable, you collect it lifecycle-aware:\n\n```kotlin\nval uiState by viewModel.uiState.collectAsStateWithLifecycle()\n```\n\n`collectAsStateWithLifecycle()` collects only while the UI is at least STARTED, so you don't waste work updating a screen the user can't see. When `uiState` changes, the composable recomposes with the new data. State flows **down** from ViewModel to UI; user events flow **up** as function calls into the ViewModel."
        ],
        [
            'question' => "Q34. Can you mix Compose and XML Views in the same app? Why would you?",
            'answer' => "Yes — **interoperability** is built in.\n\n- Put Compose **inside** XML using a `ComposeView`.\n- Put XML Views **inside** Compose using `AndroidView`.\n\n**Why you'd do it:** Real apps migrate gradually. A team rarely rewrites a huge app overnight. So you might build new screens in Compose while keeping stable old screens in XML, or embed an existing custom XML view (like a specific charting library) inside a Compose screen via `AndroidView`. Showing you understand **incremental migration** is a senior signal."
        ],
        [
            'question' => "Q35. A designer wants a custom view that doesn't exist in the framework (e.g., a circular progress meter). How do you build it?",
            'answer' => "You create a **custom View** by extending `View` (or an existing view) and overriding:\n\n- **onMeasure()** — to declare how big your view should be.\n- **onDraw(Canvas)** — to draw using the Canvas API (arcs, paths, text, paint).\n- Optionally **onTouchEvent()** for interaction.\n\nYou expose **custom XML attributes** (via `attrs.xml`) so designers can configure color/size from layouts. In Compose, the equivalent is using the **Canvas composable** with `drawArc`, `drawCircle`, etc.\n\n**Senior point:** Keep `onDraw` cheap — it can run every frame. Allocate `Paint` objects once (not inside `onDraw`), or you'll cause GC pressure and jank."
        ],
        [
            'question' => "Q36. Why does Android crash if you do network calls on the main thread? Explain the main thread.",
            'answer' => "The **main thread** (also called the UI thread) is the single thread responsible for drawing the UI and handling user input. If you block it — say, with a 3-second network call — the UI **freezes**: no scrolling, no taps respond. If it's blocked for ~5 seconds, the system shows an **ANR (Application Not Responding)** dialog.\n\nTo prevent obviously bad apps, Android throws `NetworkOnMainThreadException` if you try networking on the main thread. The rule: **never block the main thread.** Do slow work (network, disk, heavy computation) on a background thread, then post results back to the main thread to update UI."
        ],
        [
            'question' => "Q37. What is an ANR, what causes it, and how do you prevent it?",
            'answer' => "**ANR = Application Not Responding.** It appears when the main thread is blocked too long:\n\n- ~5 seconds without responding to input,\n- a BroadcastReceiver taking too long,\n- a Service not finishing on time.\n\n**Common causes:** heavy database queries, synchronous network calls, large JSON parsing, or big bitmap operations on the main thread; also deadlocks.\n\n**Prevention:**\n\n- Move all heavy work off the main thread (coroutines with `Dispatchers.IO`, WorkManager).\n- Keep `onCreate`, `onBindViewHolder`, and lifecycle methods light.\n- Use `StrictMode` during development to catch accidental main-thread disk/network access."
        ],
        [
            'question' => "Q38. You've already used threads. What do coroutines give you that plain threads don't, and why do they fit Android so well?",
            'answer' => "A **thread** is a heavyweight worker; creating thousands is expensive and they consume memory. A **coroutine** is a lightweight unit of work that _runs on_ threads but can be **suspended and resumed** without blocking the underlying thread. You can run thousands of coroutines on a small thread pool.\n\n**Why better for Android:**\n\n- They make asynchronous code look **sequential and readable** (no callback hell).\n- **Suspension** means a coroutine waiting for network doesn't block its thread — that thread does other work meanwhile.\n- They integrate with lifecycle via `viewModelScope` and `lifecycleScope`, so work is automatically cancelled when the screen goes away (preventing leaks)."
        ],
        [
            'question' => "Q39. What is `suspend` and what actually happens when a suspend function is called?",
            'answer' => "A `suspend` function is one that **can pause** at a suspension point (like awaiting a network response) and **resume later** without blocking the thread it was running on.\n\nUnder the hood, the Kotlin compiler transforms suspend functions into a **state machine** with a hidden `Continuation` parameter. When the function suspends, it saves its state and returns the thread to the pool; when the awaited result is ready, it resumes from where it left off. You write straight-line code; the compiler handles the pausing/resuming machinery.\n\nA key rule: a `suspend` function can only be called from another suspend function or a coroutine — because only those know how to handle suspension."
        ],
        [
            'question' => "Q40. Difference between `launch` and `async`? When do you use each?",
            'answer' => "Both start coroutines, but:\n\n- **launch** — \"fire and forget.\" Returns a `Job`. Use it when you don't need a result back, e.g., update the database, log an event.\n- **async** — returns a `Deferred<T>` that produces a **result**. You call `.await()` to get it. Use it for **parallel work** where you need values back.\n\n**Scenario:** You need data from two APIs at once. Start both with `async`, then `await` both — they run in parallel, cutting total time roughly in half compared to sequential calls.\n\n```csharp\nval user = async { api.getUser() }\nval posts = async { api.getPosts() }\nshowProfile(user.await(), posts.await())\n```"
        ],
        [
            'question' => "Q41. What are Dispatchers and which one do you use for what?",
            'answer' => "A **Dispatcher** decides which thread (or thread pool) a coroutine runs on.\n\n- **Dispatchers.Main** — the UI thread. Use it to touch UI.\n- **Dispatchers.IO** — a pool optimized for blocking I/O: network, disk, database.\n- **Dispatchers.Default** — a pool optimized for CPU-heavy work: sorting big lists, parsing, image processing.\n- **Dispatchers.Unconfined** — rarely used; not for app code generally.\n\n**Pattern:** Do heavy work on `IO`/`Default`, then switch back to `Main` to update the UI. With `withContext(Dispatchers.IO) { ... }` you cleanly run a block on a different dispatcher and return."
        ],
        [
            'question' => "Q42. What is structured concurrency and what real bug does it prevent?",
            'answer' => "**Structured concurrency** means coroutines are launched inside a **scope** and that scope **owns** them — if the scope is cancelled, all its child coroutines are cancelled too, and the scope won't finish until its children finish.\n\n**The bug it prevents:** \"leaked coroutines.\" Without structure, you might start a coroutine that keeps running after the user leaves the screen — updating a dead UI, leaking memory, or wasting battery. With `viewModelScope`, when the ViewModel is cleared, all its coroutines are automatically cancelled. You don't manually track and cancel them."
        ],
        [
            'question' => "Q43. The user navigates away while a network call is in flight. How do you make sure it's cancelled?",
            'answer' => "Launch the call in a **lifecycle-aware scope**:\n\n- In a ViewModel, use **viewModelScope** — cancelled automatically in `onCleared()`.\n- For UI-tied work, use **lifecycleScope** with the right `repeatOnLifecycle` state.\n\nBecause of structured concurrency, when the scope is cancelled, the coroutine receives a `CancellationException` at its next suspension point and stops. Your network library (Retrofit + coroutines) supports cancellation, so the in-flight request is dropped.\n\n**Senior point:** Make sure your code is **cooperative with cancellation** — if you catch `Exception` broadly with `try/catch`, don't accidentally swallow `CancellationException`, or you'll break cancellation. Re-throw it."
        ],
        [
            'question' => "Q44. What is a CoroutineScope vs a CoroutineContext vs a Job?",
            'answer' => "- **Job** — a handle to a coroutine's lifecycle; you can cancel it, check if it's active, wait for it. Coroutines form a parent-child **Job hierarchy**.\n- **CoroutineContext** — a set of elements that configure a coroutine: the Job, the Dispatcher, a name, an exception handler. It's like the \"environment\" the coroutine runs in.\n- **CoroutineScope** — ties coroutines to a lifecycle by holding a context (especially a Job). You launch coroutines _in_ a scope. When the scope's Job is cancelled, its coroutines stop.\n\n**Mental model:** Scope = \"who owns these coroutines and when do they die,\" Context = \"how they're configured,\" Job = \"the controllable handle to one coroutine and its children.\""
        ],
        [
            'question' => "Q45. What is a Flow, and how is it different from a suspend function returning a list?",
            'answer' => "A **suspend function** returns **one** value, once. A **Flow** is a stream that can emit **many values over time**, asynchronously — like a pipe that keeps delivering updates.\n\n**Real use:** Observing a database table with Room — when the data changes, the Flow emits a fresh list automatically, so the UI stays live. Or a search box where each keystroke produces new results.\n\nFlows are **cold** by default: nothing runs until you `collect`. They're built on coroutines, so they're cancellable and respect structured concurrency."
        ],
        [
            'question' => "Q46. Explain StateFlow vs SharedFlow vs LiveData — when do you reach for each?",
            'answer' => "- **LiveData** — lifecycle-aware observable holding a single current value. Older, simple, but tied to the Android framework and a bit limited.\n- **StateFlow** — a Flow that always holds **one current value** (state). New collectors immediately get the latest value. Perfect for **UI state** that the screen renders.\n- **SharedFlow** — a Flow for **events** that can have multiple collectors and configurable replay. Use it for **one-time events** like \"show a toast,\" \"navigate,\" \"show a snackbar\" — things you don't want re-fired on rotation.\n\n**Rule:** State the screen renders → **StateFlow**. One-shot events → **SharedFlow** (or a Channel). LiveData is fine in older codebases but Flow is the modern default."
        ],
        [
            'question' => "Q47. What is WorkManager and when is it the right tool (vs a coroutine or service)?",
            'answer' => "**WorkManager** schedules **deferrable, guaranteed background work** that should run **even if the app is closed or the device reboots**. It picks the right underlying mechanism for the OS version and respects battery optimizations.\n\n**Use it for:** syncing data to a server, uploading logs, periodic backups, downloading content for later. These must complete eventually but don't need to happen _right now_ on screen.\n\n**Don't use it for:** quick work tied to the current screen (use a coroutine in `viewModelScope`), or immediate user-visible ongoing tasks like music playback (use a **foreground service**).\n\n**Key strengths:** constraints (only on Wi-Fi, only when charging), retry with backoff, and chaining work."
        ],
        [
            'question' => "Q48. The interviewer asks: \"Schedule a sync that only runs on Wi-Fi and when charging, and retries on failure.\" How?",
            'answer' => "This is exactly **WorkManager with constraints**:\n\n```java\nval constraints = Constraints.Builder()\n    .setRequiredNetworkType(NetworkType.UNMETERED) // Wi-Fi\n    .setRequiresCharging(true)\n    .build()\n\nval work = OneTimeWorkRequestBuilder<SyncWorker>()\n    .setConstraints(constraints)\n    .setBackoffCriteria(BackoffPolicy.EXPONENTIAL, 10, TimeUnit.SECONDS)\n    .build()\nWorkManager.getInstance(context).enqueue(work)\n```\n\nInside `SyncWorker.doWork()`, you return `Result.retry()` on a transient failure and WorkManager re-runs it later with exponential backoff. This shows you know constraints, backoff, and the `Result` contract."
        ],
        [
            'question' => "Q49. What is the difference between a foreground service, a background service, and WorkManager today?",
            'answer' => "- **Foreground service** — runs a user-visible ongoing task with a **persistent notification** (music player, fitness tracking, navigation). The notification is mandatory so users know it's running.\n- **Background service** — heavily restricted on modern Android; the system kills background work aggressively to save battery. Mostly replaced by other tools.\n- **WorkManager** — the right choice for deferrable guaranteed work. It survives app death and reboot.\n\n**Modern reality:** Use foreground services only for ongoing, user-aware tasks; use WorkManager for everything deferrable. Plain background services are largely discouraged."
        ],
        [
            'question' => "Q50. What is a Handler and Looper? (The classic \"how does the main thread actually work\" question.)",
            'answer' => "The main thread runs an infinite loop called the **Looper**, which pulls messages/tasks off a **MessageQueue** one at a time and processes them. A **Handler** lets you **post** messages or `Runnable`s onto that queue for a specific thread.\n\nThis is how \"post back to the main thread\" works under the hood: a background thread uses a Handler bound to the main Looper to enqueue a UI update, which the main thread then processes in its loop.\n\n**Why it matters:** Coroutines' `Dispatchers.Main` is built on this mechanism. Understanding Looper/Handler shows you know what's _beneath_ the abstractions."
        ],
        [
            'question' => "Q51. Walk me through what happens from the moment a user taps \"Load\" to data appearing on screen.",
            'answer' => "1. The UI sends an event to the **ViewModel** (e.g., `loadData()`).\n2. The ViewModel launches a coroutine in `viewModelScope`, sets UI state to **Loading**.\n3. It calls a **Repository**, which calls a **Retrofit API** method.\n4. Retrofit (with OkHttp underneath) builds the HTTP request, runs it on a background thread, and gets a response.\n5. A **converter** (like Moshi/Gson/kotlinx.serialization) parses the JSON into Kotlin data classes.\n6. The Repository may cache the result (Room) and returns the data.\n7. The ViewModel updates UI state to **Success(data)** (or **Error**).\n8. The UI, observing the state, recomposes/re-renders to show the data.\n\nDescribing this clean flow — UI → ViewModel → Repository → API → back — demonstrates you understand layered architecture, not just \"call Retrofit.\""
        ],
        [
            'question' => "Q52. What is Retrofit and why not just use raw HttpURLConnection?",
            'answer' => "**Retrofit** is a type-safe HTTP client. You declare your API as a Kotlin interface with annotations, and Retrofit generates the implementation:\n\n```kotlin\ninterface UserApi {\n    @GET(\"users/{id}\")\n    suspend fun getUser(@Path(\"id\") id: String): UserDto\n}\n```\n\n**Why not raw connections:** With `HttpURLConnection` you manually open streams, handle threading, read bytes, parse JSON, manage errors, and write tons of boilerplate. Retrofit handles request building, threading, serialization, and error mapping cleanly, and integrates with coroutines and Flow. It sits on top of **OkHttp**, which provides connection pooling, caching, interceptors, and retries."
        ],
        [
            'question' => "Q53. What is an OkHttp Interceptor and give two real uses.",
            'answer' => "An **interceptor** sits in the middle of the request/response pipeline and can read or modify both. Two common uses:\n\n1. **Auth interceptor** — automatically attach the `Authorization: Bearer <token>` header to every request, so you don't repeat it in every API call.\n2. **Logging interceptor** — log requests/responses during development for debugging.\n\nOther uses: adding common headers, retrying, caching control, and **token refresh** (via an `Authenticator`) when a request returns 401."
        ],
        [
            'question' => "Q54. A token expires mid-session and APIs start returning 401. How do you refresh it without breaking the user's flow?",
            'answer' => "You use an OkHttp **Authenticator** (or a carefully built interceptor). When a request comes back **401 Unauthorized**, the Authenticator:\n\n1. Synchronously refreshes the token using the refresh-token endpoint.\n2. Saves the new token.\n3. Retries the original request with the new token.\n\n**Critical detail interviewers probe:** Handle **concurrent 401s**. If five requests fail at once, you don't want five refresh calls. Use a lock/mutex so only one refresh happens and the others wait for and reuse the new token. Mentioning this race condition is a strong senior signal."
        ],
        [
            'question' => "Q55. How do you handle errors from the network so the UI shows something sensible?",
            'answer' => "Wrap results in a **sealed type** that represents every outcome:\n\n```kotlin\nsealed interface Result<out T> {\n    data class Success<T>(val data: T) : Result<T>\n    data class Error(val message: String, val code: Int? = null) : Result<Nothing>\n    object Loading : Result<Nothing>\n}\n```\n\nIn the repository, catch exceptions (no internet → `IOException`, server errors → non-2xx codes, parsing errors) and map them to a friendly `Error`. The UI then renders different states: spinner for Loading, content for Success, a retry message for Error.\n\n**Why sealed:** the compiler forces you to handle **every** case in a `when`, so you can't forget the error state — which is exactly the state that gets forgotten and causes blank screens."
        ],
        [
            'question' => "Q56. The user is on a flaky train connection. How do you make networking resilient?",
            'answer' => "- **Timeouts** — set sensible connect/read/write timeouts in OkHttp so requests don't hang forever.\n- **Retries with backoff** — retry transient failures, increasing the wait each time, but cap the attempts.\n- **Caching** — serve cached data when offline (OkHttp HTTP cache and/or a Room cache as single source of truth).\n- **Offline-first** — read from the local database first (instant UI), then refresh from network in the background and update the DB, which updates the UI via Flow.\n- **Clear UI feedback** — show \"offline\" / \"retrying\" states instead of an infinite spinner.\n\n**Senior point:** The best UX here is **offline-first with the database as the single source of truth** — the network just keeps the DB fresh."
        ],
        [
            'question' => "Q57. What is the difference between Gson, Moshi, and kotlinx.serialization?",
            'answer' => "All three convert JSON ↔ Kotlin objects.\n\n- **Gson** — old, widely used, reflection-based, but doesn't understand Kotlin nullability well (can put `null` into non-null fields, causing surprise crashes).\n- **Moshi** — Kotlin-aware, can use codegen (no reflection at runtime), respects nullability and defaults better. A solid choice.\n- **kotlinx.serialization** — official Kotlin library, compile-time generated, multiplatform-friendly, fully respects Kotlin types.\n\n**Interview-worthy point:** Prefer Moshi or kotlinx.serialization over Gson on modern Kotlin projects, mainly because of **null-safety correctness** and no runtime reflection."
        ],
        [
            'question' => "Q58. What is pagination and why does it matter for a feed with thousands of items?",
            'answer' => "**Pagination** means loading data in small **pages** (e.g., 20 items at a time) instead of all at once. Loading 10,000 items in one call would be slow, use huge memory, and waste data the user may never scroll to.\n\nThe **Paging 3** library handles this: it loads pages as the user scrolls, shows loading spinners at the list's edge, handles retries, and integrates with Room (load from DB, fetch more from network via `RemoteMediator`). It also handles the tricky parts — placeholders, dedup, and configuration changes — that are painful to do by hand."
        ],
        [
            'question' => "Q59. A user toggles dark mode. After restarting the app, it forgot the setting. Where should you store it and why?",
            'answer' => "A simple key-value preference like this belongs in **DataStore** (specifically Preferences DataStore), the modern replacement for SharedPreferences.\n\n**Why not just a variable:** variables die with the process. **Why DataStore over SharedPreferences:** SharedPreferences has a synchronous API (`getString`) that can block the main thread and an error-prone `commit()`/`apply()`. DataStore is **asynchronous (Flow + coroutines)**, transactional, and safe — no main-thread disk reads, no silent data corruption.\n\nSo: save the toggle to DataStore, read it as a Flow at startup, and apply the theme. Done."
        ],
        [
            'question' => "Q60. SharedPreferences vs DataStore vs Room vs Files — how do you choose?",
            'answer' => "- **DataStore** — small key-value settings (theme, flags, last user ID). Asynchronous, safe.\n- **Room** — **structured/relational** data: lists of records you query, filter, and relate (orders, messages, cached API data). It's a layer over SQLite.\n- **Files** — large blobs: images, downloaded PDFs, videos, cached media. Store in internal/external storage, keep paths in the DB.\n- **SharedPreferences** — legacy key-value; use DataStore for new code.\n\n**Rule:** _Settings → DataStore. Queryable records → Room. Big binaries → Files._"
        ],
        [
            'question' => "Q61. What is Room and what does it give you over raw SQLite?",
            'answer' => "**Room** is an abstraction layer over SQLite that removes boilerplate and adds safety:\n\n- **Compile-time SQL verification** — your `@Query` SQL is checked when you build, so typos are caught early instead of crashing at runtime.\n- **Less boilerplate** — no manual cursor handling; you get Kotlin objects back.\n- **Coroutine & Flow support** — `suspend` DAO methods and `Flow` queries that emit on data changes.\n- **Migrations** support for schema changes.\n\nYou define **Entities** (tables), a **DAO** (queries), and a **Database** class. Room generates the implementation."
        ],
        [
            'question' => "Q62. Explain Entity, DAO, and Database in Room with a simple example.",
            'answer' => "- **Entity** — a class mapped to a table. Each instance is a row.\n\n```less\n @Entity data class Note(@PrimaryKey val id: Int, val text: String)\n```\n\n- **DAO (Data Access Object)** — an interface with your queries.\n\n```kotlin\n@Dao interface NoteDao {\n      @Insert suspend fun insert(note: Note)\n      @Query(\"SELECT * FROM Note\") fun getAll(): Flow<List<Note>>\n  }\n```\n\n- **Database** — the holder that ties entities and DAOs together and creates the SQLite database.\n\n```kotlin\n@Database(entities = [Note::class], version = 1)\n  abstract class AppDatabase : RoomDatabase() {\n      abstract fun noteDao(): NoteDao\n  }\n```"
        ],
        [
            'question' => "Q63. You add a new column to a table and existing users' apps crash on update. Why, and how do you fix it?",
            'answer' => "Room verifies the database schema against your entities. When you change the schema (new column) but bump the version without telling Room **how** to migrate, it throws `IllegalStateException` — the existing on-device database doesn't match the new schema.\n\n**Fix:** provide a **Migration** that runs the SQL to alter the existing database:\n\n```kotlin\nval MIGRATION_1_2 = object : Migration(1, 2) {\n    override fun migrate(db: SupportSQLiteDatabase) {\n        db.execSQL(\"ALTER TABLE Note ADD COLUMN pinned INTEGER NOT NULL DEFAULT 0\")\n    }\n}\n```\n\n**Never** ship `fallbackToDestructiveMigration()` to production for real user data — it **wipes the database** on schema change, deleting user data. That's a classic interview trap; call it out."
        ],
        [
            'question' => "Q64. What does it mean that a Room Flow query is \"reactive,\" and why is it powerful?",
            'answer' => "If your DAO returns `Flow<List<Note>>`, Room **re-emits** the query results automatically whenever the underlying table changes. So if you insert a note in one place, every screen observing that Flow updates instantly — no manual refresh, no event bus.\n\n**Why powerful:** the database becomes the **single source of truth**. The UI just observes; it never has to be told \"data changed, please reload.\" This eliminates a whole class of \"stale UI\" bugs."
        ],
        [
            'question' => "Q65. Where should you NOT store sensitive data like auth tokens, and where should you?",
            'answer' => "**Don't** store tokens in plain SharedPreferences/DataStore or plain text files — they're readable on rooted devices and in backups.\n\n**Do** use:\n\n- **EncryptedSharedPreferences** / encrypted DataStore (via Jetpack Security / Tink) for small secrets.\n- The **Android Keystore** to store cryptographic keys that never leave secure hardware; encrypt sensitive values with a Keystore-backed key.\n- For the most sensitive flows, avoid storing long-lived secrets on device at all; use short-lived tokens.\n\n**Senior point:** mention that even encrypted storage isn't magic on a compromised (rooted) device, so minimize what you store and how long."
        ],
        [
            'question' => "Q66. Internal storage vs external storage vs scoped storage — what's the difference?",
            'answer' => "- **Internal storage** — private to your app, sandboxed; deleted when the app is uninstalled. Good for private files.\n- **External storage** — historically shared/public space (SD card / shared partition). Other apps could access it.\n- **Scoped storage (Android 10+)** — tightened the rules: apps get private app-specific external directories, and access to shared media (photos, downloads) goes through the **MediaStore** API or the **Storage Access Framework / Photo Picker**, not raw file paths.\n\n**Why it changed:** privacy and security — apps shouldn't roam the whole filesystem. For user-picked files, use the **Photo Picker** or document picker so you only get what the user explicitly chose."
        ],
        [
            'question' => "Q67. How would you implement an offline-first feature (e.g., a notes app that works without internet)?",
            'answer' => "**Database as the single source of truth:**\n\n1. The UI observes notes from **Room** (a Flow). It shows local data instantly, online or offline.\n2. When the user creates/edits a note, write to **Room first** (so it's instantly visible and never lost) and mark it as \"needs sync.\"\n3. A **WorkManager** sync job pushes unsynced changes to the server when connectivity returns, and pulls remote changes into Room.\n4. The UI never talks to the network directly — it only watches the database, which the sync layer keeps fresh.\n\n**Senior depth:** mention **conflict resolution** (what if the same note changed on two devices) — last-write-wins, version numbers, or merge strategies."
        ],
        [
            'question' => "Q68. What is a transaction and when do you need one in Room?",
            'answer' => "A **transaction** groups multiple database operations so they either **all succeed or all fail together** — there's no half-finished state.\n\n**When you need it:** transferring \"ownership\" of related rows, inserting a parent and its children together, or any multi-step update that must stay consistent. In Room, annotate a method with `@Transaction` (or use `database.withTransaction { }`), and if anything inside throws, all changes roll back.\n\n**Example:** deducting from one account and adding to another must be atomic — you can't subtract money and then fail before adding it."
        ],
        [
            'question' => "Q69. Walk me through MVVM using a real screen as an example.",
            'answer' => "**MVVM = Model–View–ViewModel.** Take a profile screen.\n\n- **Model** — the data and business logic: the `User` object, the repository that fetches it. It knows nothing about the UI.\n- **View** — the screen (Activity/Fragment/Composable). It's \"dumb\": it just displays state and forwards user actions. It knows nothing about how data is fetched.\n- **ViewModel** — the middle layer. It exposes **UI state** (loading/success/error + the user data) and handles events from the View by calling the Model. It survives configuration changes.\n\n**Flow:** View observes ViewModel state → renders it. User acts → View tells ViewModel → ViewModel updates Model → new state flows back to View. The View and Model never talk directly, which keeps things testable and decoupled."
        ],
        [
            'question' => "Q70. Why is the ViewModel so important? What problem was it invented to solve?",
            'answer' => "Two big problems:\n\n1. **Surviving configuration changes.** Before ViewModel, rotating the screen destroyed your Activity and lost in-progress data and ongoing tasks. ViewModel **outlives** rotation, so data and running coroutines persist.\n2. **Separation of concerns.** Putting network calls, state, and business logic directly in Activities created giant, untestable \"god classes.\" ViewModel pulls that logic out into a UI-agnostic class you can unit test without Android.\n\n**Crucial rule:** A ViewModel must **never hold a reference to a View, Activity, or Context** (use AndroidViewModel/Application if you truly need app context). Holding a View leaks memory because the ViewModel outlives the View."
        ],
        [
            'question' => "Q71. What is a Repository and why add another layer?",
            'answer' => "A **Repository** is the single place that owns access to a type of data, hiding _where_ the data comes from. The ViewModel asks the Repository for \"the user\"; the Repository decides whether to return cached data from Room or fetch from the network — the ViewModel doesn't care.\n\n**Why add it:**\n\n- **Single source of truth** and one place for caching logic.\n- The ViewModel stays focused on UI state, not data plumbing.\n- **Swappable data sources** — you can change from one API to another, or add caching, without touching the ViewModel.\n- **Testability** — mock the Repository to test the ViewModel."
        ],
        [
            'question' => "Q72. Explain Clean Architecture's layers and the dependency rule.",
            'answer' => "Clean Architecture splits the app into concentric layers:\n\n- **Presentation** (UI, ViewModel) — shows state, handles input.\n- **Domain** (use cases, business rules, entities) — pure Kotlin, no Android, the heart of the app.\n- **Data** (repositories, APIs, databases) — fetches and stores data.\n\n**The dependency rule:** dependencies point **inward**. Outer layers depend on inner layers, never the reverse. The domain layer knows nothing about Android, Retrofit, or Room. This makes business logic **independent of frameworks**, so it's easy to test and swap implementations.\n\n**When to use it:** large, long-lived apps with complex business rules. For a tiny app it can be overkill — say that, because over-engineering is also a red flag."
        ],
        [
            'question' => "Q73. What is a Use Case (Interactor) and when is it worth having?",
            'answer' => "A **Use Case** encapsulates **one specific business action** — \"log in user,\" \"get filtered orders,\" \"calculate cart total.\" It sits between ViewModel and Repository in Clean Architecture.\n\n**Worth it when:**\n\n- The same business logic is reused across multiple ViewModels.\n- A single action combines data from multiple repositories.\n- You want the business rule isolated and unit-tested independently.\n\n**Not worth it when:** the use case would just call a single repository method with no logic — that's a pointless pass-through. Knowing when _not_ to add a layer is senior-level judgment."
        ],
        [
            'question' => "Q74. MVVM vs MVI — what's the difference and why might you choose MVI?",
            'answer' => "- **MVVM** — ViewModel exposes multiple state pieces; the View observes them. State can be spread across several LiveData/Flows.\n- **MVI (Model–View–Intent)** — there is **one single immutable state object** for the whole screen, updated through a single stream. The UI sends **intents** (user actions); the ViewModel reduces them into a new state; the UI renders that one state.\n\n**Why choose MVI:**\n\n- **Single source of truth** per screen → fewer \"inconsistent UI\" bugs.\n- **Predictable, unidirectional data flow** → easier to reason about and debug.\n- Great fit with Compose's state-driven model.\n\n**Trade-off:** more boilerplate. For simple screens MVVM is lighter."
        ],
        [
            'question' => "Q75. What is \"Unidirectional Data Flow\" (UDF) and why does it reduce bugs?",
            'answer' => "**UDF** means data flows in **one direction**: state flows **down** from the ViewModel to the UI, and events flow **up** from the UI to the ViewModel. The UI never mutates state directly; it asks the ViewModel to change it, and the new state flows back down.\n\n**Why fewer bugs:** there's exactly **one owner** of state (the ViewModel) and **one path** to change it. You never have two places fighting over the truth, and you can always answer \"why is the UI in this state?\" by looking at the single state object. This is the foundation of both modern Compose and MVI."
        ],
        [
            'question' => "Q76. What is the Observer pattern and where does Android use it constantly?",
            'answer' => "The **Observer pattern**: an object (the subject) maintains a list of dependents (observers) and notifies them automatically when it changes.\n\nAndroid uses it everywhere:\n\n- **LiveData / StateFlow** — the UI observes; when data changes, the UI is notified and updates.\n- **RecyclerView adapters** observe data changes.\n- **Room Flow queries** notify on table changes.\n\nIt's the backbone of reactive UI: \"tell me when this changes\" instead of \"let me keep polling to check.\""
        ],
        [
            'question' => "Q77. What is dependency inversion and why does it make code testable?",
            'answer' => "**Dependency Inversion Principle:** depend on **abstractions (interfaces)**, not concrete classes. So a ViewModel depends on a `UserRepository` _interface_, not a specific `UserRepositoryImpl`.\n\n**Why testable:** in a unit test you can inject a **fake** implementation of the interface that returns canned data — no real network, no database. The ViewModel doesn't know or care which implementation it got. This decoupling is what makes large codebases maintainable and testable, and it's what DI frameworks (Hilt) wire up for you."
        ],
        [
            'question' => "Q78. A junior wrote all the logic inside the Activity. What problems will this cause and how do you refactor?",
            'answer' => "**Problems:**\n\n- **Lost work on rotation** — logic and state die with the Activity.\n- **Untestable** — you can't unit test an Activity without the Android framework.\n- **Memory leaks** — long tasks holding the Activity context.\n- **God class** — thousands of lines, impossible to maintain.\n\n**Refactor path:**\n\n1. Move state and logic into a **ViewModel**.\n2. Move data access into a **Repository**.\n3. Make the Activity/Fragment just observe state and forward events.\n4. Inject dependencies so each piece is testable.\n\nThis is essentially \"apply MVVM,\" and explaining the _why_ (testability, lifecycle safety) matters more than the buzzword."
        ],
        [
            'question' => "Q79. What is the Singleton pattern and what's the danger of overusing it in Android?",
            'answer' => "A **Singleton** ensures only one instance of a class exists app-wide (e.g., a single database or network client).\n\n**The danger:** singletons holding a **Context** (especially an Activity context) leak memory because they live for the whole app. They also create **hidden global state** that's hard to test and reason about (everything secretly depends on them). In Android, prefer letting a **DI framework** manage single instances (`@Singleton` in Hilt) with the **application context**, rather than hand-rolling `object` singletons that grab contexts."
        ],
        [
            'question' => "Q80. How do you decide how much architecture an app needs?",
            'answer' => "By matching architecture to **complexity and lifespan**:\n\n- A tiny utility app: MVVM + a couple of ViewModels is plenty. Adding Clean Architecture, use cases, and multiple modules would be **over-engineering**.\n- A large, team-built, long-lived product: layered Clean Architecture, modularization, use cases, and strict boundaries pay off in maintainability and parallel teamwork.\n\n**The senior mindset:** architecture is a tool to manage complexity, not a trophy. Add structure when the pain of _not_ having it appears (hard testing, merge conflicts, tangled code), not pre-emptively everywhere. Saying this shows maturity beyond memorized patterns."
        ],
        [
            'question' => "Q81. What is dependency injection, and can you give an analogy that makes it click?",
            'answer' => "**Dependency injection (DI)** means a class doesn't create the things it needs — those things are **handed to it** from outside.\n\n**Analogy:** A chef shouldn't have to go farm vegetables and raise chickens before cooking. The ingredients are _delivered_ to the kitchen. The chef just cooks. Similarly, a ViewModel shouldn't create its own Repository, network client, and database — those are **injected** into it.\n\n**Why:**\n\n- **Testability** — you can deliver _fake_ ingredients (mock dependencies) in tests.\n- **Reusability & decoupling** — the class depends on what it's given, not on building everything itself.\n- **Single place** to control how objects are created and shared."
        ],
        [
            'question' => "Q82. What is Hilt and what does it do for you?",
            'answer' => "**Hilt** is Google's DI framework for Android, built on Dagger. You declare _how_ to create objects (in **modules**), annotate where you need them (`@Inject`), and Hilt generates all the wiring code at **compile time**.\n\n**What it gives you:**\n\n- **Android-aware scopes** — `@Singleton` (app-wide), `@ActivityScoped`, `@ViewModelScoped`, etc., so objects live exactly as long as they should.\n- **Automatic injection** into Activities, Fragments, ViewModels, and Workers.\n- **Compile-time safety** — missing dependencies are caught when you build, not at runtime.\n\n**Setup basics:** `@HiltAndroidApp` on the Application, `@AndroidEntryPoint` on Activities/Fragments, `@HiltViewModel` on ViewModels."
        ],
        [
            'question' => "Q83. Constructor injection vs field injection — which is better and why?",
            'answer' => "- **Constructor injection** — dependencies are passed into the constructor. Preferred because the object is **fully formed and valid** the moment it's created, dependencies are **explicit** (you can see them in the signature), and it's **easy to test** (just pass fakes in).\n- **Field injection** — dependencies are set into fields after construction. Needed for Android framework classes you don't construct yourself (Activities, Fragments), because the system creates them.\n\n**Rule:** Use **constructor injection** everywhere you can (ViewModels, repositories). Use field injection only where the framework owns the object's creation."
        ],
        [
            'question' => "Q84. What is a scope in DI, and what bug does the wrong scope cause?",
            'answer' => "A **scope** controls how long an injected object lives and who shares it.\n\n- `@Singleton` — one instance for the whole app.\n- `@ActivityScoped` — one per Activity, shared by its fragments.\n- `@ViewModelScoped` — tied to a ViewModel's life.\n\n**Bug from wrong scope:** If you scope something to an Activity but it secretly holds the Activity context and you accidentally make it a singleton, it **leaks the Activity** for the app's lifetime. Or, if you wanted a shared cache to be app-wide but scope it per-Activity, each screen gets its own copy and the cache \"doesn't work.\" Matching lifetime to purpose is the whole point of scopes."
        ],
        [
            'question' => "Q85. Could you do DI manually without Hilt? When might you?",
            'answer' => "Yes — **manual DI** means creating and passing dependencies yourself, often through a container object or factory. For a **small app**, manual DI is perfectly fine and avoids the build-time cost and learning curve of Hilt.\n\n**When manual:** small apps, libraries that shouldn't force a DI framework on consumers, or learning/teaching. **When Hilt:** medium-to-large apps where wiring becomes tedious and error-prone, and you want scopes and lifecycle integration handled for you.\n\n**Senior point:** DI is a _principle_; Hilt is a _tool_. You can follow the principle by hand. Saying this shows you understand the concept rather than just the library."
        ],
        [
            'question' => "Q86. What is a memory leak in Android, give the most common cause, and how to detect it.",
            'answer' => "A **memory leak** is when objects that should be freed are kept alive because something still references them, so the garbage collector can't reclaim them. Over time, memory grows and the app slows or crashes with `OutOfMemoryError`.\n\n**Most common cause:** holding a reference to an **Activity/Context** beyond its life — e.g., a static field, a singleton, a long-running background task, or an inner class/listener that outlives the Activity. The Activity is destroyed but can't be collected because something still points to it.\n\n**Detection:** **LeakCanary** (a library that automatically detects and reports leaks), the **Android Studio Memory Profiler**, and heap dumps. LeakCanary even shows you the exact reference chain causing the leak."
        ],
        [
            'question' => "Q87. Why are inner classes and anonymous listeners a classic leak source?",
            'answer' => "A **non-static inner class** (and anonymous classes like a click listener defined inside an Activity) holds an **implicit reference to its outer class** (the Activity). If that inner object outlives the Activity — say it's a long-running `Handler` callback, a background thread, or a singleton's listener — it keeps the whole Activity in memory.\n\n**Fix:** use static/nested classes with a `WeakReference` to the Activity, remove listeners in `onDestroy`/`onStop`, prefer lifecycle-aware components (coroutines in `viewModelScope`, `lifecycleScope`) that auto-cancel, and never let a singleton hold an Activity context."
        ],
        [
            'question' => "Q88. The app's memory keeps climbing while scrolling an image feed. What's going wrong?",
            'answer' => "Almost certainly **bitmap (image) handling**:\n\n- Loading **full-resolution** images into small views — a 4000×3000 photo in a 200px thumbnail wastes enormous memory.\n- No caching or reuse, so images reload and pile up.\n- Decoding bitmaps on the main thread (also causes jank).\n\n**Fixes:**\n\n- Use **Glide/Coil**, which **downsample** images to the target size, cache them (memory + disk), and load off the main thread.\n- Load the right resolution for the view.\n- Free bitmaps you no longer need.\n\nBitmaps are usually the #1 memory hog in real apps — interviewers love this one."
        ],
        [
            'question' => "Q89. What is \"jank\" and the 16ms rule?",
            'answer' => "To feel smooth at 60 frames per second, the device must render each frame in about **16 milliseconds** (1000ms ÷ 60). If a frame takes longer — because the main thread is busy — frames are dropped and the UI **stutters**. That stutter is called **jank**.\n\n**Causes:** heavy work on the main thread during scroll, complex/overdrawn layouts, big bitmap decodes, excessive object allocation triggering garbage collection.\n\n**On 90/120Hz screens** the budget is even tighter (~11ms / ~8ms). Mentioning high-refresh displays shows current awareness."
        ],
        [
            'question' => "Q90. What is overdraw and how do you reduce it?",
            'answer' => "**Overdraw** is the GPU painting the **same pixel multiple times** in one frame e.g., a background, then a card on top, then another view on top of that, all opaque and stacked. Wasted painting costs performance.\n\n**Reduce it by:**\n\n- Removing unnecessary backgrounds (don't set a background on a view that's fully covered).\n- Flattening the view hierarchy.\n- Using the **\"Debug GPU Overdraw\"** developer option (it color-codes overdraw — too much red is bad)."
        ],
        [
            'question' => "Q91. Your app drains battery fast. What are the usual suspects?",
            'answer' => "- **Wakelocks held too long** — keeping the CPU awake unnecessarily.\n- **Frequent location updates** at high accuracy when you don't need them.\n- **Polling the network** on a timer instead of using push or batched syncs.\n- **Background work** not deferred (use WorkManager with constraints so work batches during charging/Wi-Fi).\n- **Frequent GPS / sensors** left running after the screen is gone.\n\n**Fixes:** batch and defer work, use the right location accuracy and update interval, release sensors/camera in `onStop`, and let WorkManager + Doze/App Standby schedule work efficiently. The OS aggressively restricts background work specifically to protect battery, so work _with_ the system, not against it."
        ],
        [
            'question' => "Q92. What is the garbage collector's relationship to performance? Can you cause GC problems?",
            'answer' => "The **garbage collector (GC)** frees memory used by objects no longer referenced. Modern Android GC is concurrent, but **excessive object allocation** still hurts: allocating many short-lived objects (especially in `onDraw`, `onBindViewHolder`, or tight loops) forces frequent GC, and GC pauses can cause jank.\n\n**Avoid GC churn by:**\n\n- Not allocating inside hot paths (reuse objects; allocate `Paint`/buffers once).\n- Avoiding autoboxing of primitives in loops.\n- Using object pools where appropriate.\n\n\"Don't allocate in `onDraw`\" is a line that signals real profiling experience."
        ],
        [
            'question' => "Q93. What is StrictMode and how does it help you ship a faster app?",
            'answer' => "**StrictMode** is a developer tool that **detects accidental bad behavior** on the main thread — like disk reads/writes or network calls — and flags it (log, flash the screen, or even crash in debug). You enable it in debug builds.\n\n**Why it helps:** it catches main-thread I/O _during development_, before it becomes a user-facing ANR or jank in production. It also detects leaked Closeables and some leaks. Mentioning StrictMode shows you build performance discipline into development, not just fix problems after the fact."
        ],
        [
            'question' => "Q94. How do you reduce your app's APK/AAB size, and why does it matter?",
            'answer' => "**Why it matters:** smaller apps install faster, get more downloads (especially on cheaper devices and slower networks — very relevant in markets like India), and update faster.\n\n**Techniques:**\n\n- Ship an **Android App Bundle (AAB)** so Google Play delivers device-specific APKs (only the needed resources/densities/architectures).\n- Enable **R8** (code shrinking, obfuscation, optimization) to remove unused code.\n- Enable **resource shrinking** to drop unused resources.\n- Compress images, use **WebP/vector drawables**, remove unused libraries.\n- Use **dynamic feature modules** to load rarely-used features on demand."
        ],
        [
            'question' => "Q95. What tools do you use to actually find performance problems (not guess)?",
            'answer' => "- **Android Studio Profiler** — CPU, Memory, Network, Energy in real time.\n- **Layout Inspector** — inspect the view hierarchy and find deep nesting/overdraw.\n- **Perfetto / System Trace** — frame-level timeline to find jank and what's blocking the main thread.\n- **LeakCanary** — automatic leak detection.\n- **Macrobenchmark / Baseline Profiles** — measure and improve startup and scroll performance; baseline profiles precompile hot code paths for faster cold starts.\n- **StrictMode** — catch main-thread I/O early.\n\n**Senior mindset:** \"**Measure first, then optimize.**\" Guessing where the bottleneck is wastes time and often optimizes the wrong thing."
        ],
        [
            'question' => "Q96. How do you store an API key or secret safely in an Android app?",
            'answer' => "First, accept the hard truth: **anything shipped in the app can eventually be extracted** by a determined attacker (decompiling the APK). So:\n\n- **Never** hardcode secrets in plain code or `strings.xml`.\n- Keep secrets **out of the client** entirely when possible — route sensitive calls through **your own backend** that holds the real secret.\n- For values that must be on-device, use the **Android Keystore** and **EncryptedSharedPreferences**, and obfuscate with R8.\n- Use **certificate pinning** to prevent man-in-the-middle interception.\n\n**Senior point:** the right framing is \"**minimize and protect**, but assume the client is hostile territory.\" Backend-side secrets beat client-side every time."
        ],
        [
            'question' => "Q97. What is HTTPS and certificate pinning, and what attack does pinning stop?",
            'answer' => "**HTTPS** encrypts traffic between app and server so attackers on the network can't read or tamper with it.\n\n**Certificate pinning** goes further: your app only trusts a **specific** server certificate/public key, not just any certificate a Certificate Authority signed. This stops **man-in-the-middle (MITM)** attacks where an attacker installs a rogue CA (or tricks the device) to present a fake-but-\"valid\" certificate and intercept traffic.\n\n**Trade-off:** pinned certificates expire/rotate; if you pin and forget to update, you can break your own app. So pin carefully with backup pins and a rotation plan."
        ],
        [
            'question' => "Q98. What is the principle of least privilege with permissions, and why request permissions at runtime?",
            'answer' => "**Least privilege** means request **only** the permissions you actually need, and only **when** you need them. Asking for everything upfront scares users and risks rejection (and review issues).\n\n**Runtime permissions (Android 6+):** dangerous permissions (camera, location, contacts) must be **requested at runtime, in context**, with a clear reason — not just declared in the manifest. Ask for location _when the user taps \"find nearby,\"_ explain why, and handle denial gracefully (the feature degrades, the app doesn't crash). Modern Android also offers **one-time** and **approximate** location, and a **Photo Picker** that needs no broad storage permission at all."
        ],
        [
            'question' => "Q99. How do you prevent SQL injection and unsafe data handling?",
            'answer' => "**SQL injection** happens when user input is concatenated directly into a query, letting an attacker alter it. **Prevention:** always use **parameterized queries / bind arguments**. Room does this for you when you use `:param` placeholders in `@Query` — never build SQL by string concatenation with raw input.\n\nMore broadly: **validate and sanitize all input**, don't trust data from intents/deep links/other apps, use `exported=false` for components that shouldn't be externally accessible, and validate any URL/deep-link parameters before acting on them."
        ],
        [
            'question' => "Q100. What are common Android security mistakes you'd check for in a code review?",
            'answer' => "- **Logging sensitive data** (tokens, passwords, PII) — easily read via logcat.\n- **Exported components** (`exported=true`) that shouldn't be, letting other apps trigger them.\n- **Hardcoded secrets** in code or resources.\n- **Disabling SSL verification** or accepting all certificates \"to make it work.\"\n- **Storing secrets in plain SharedPreferences**.\n- **Implicit intents** carrying sensitive data that another app could intercept.\n- **WebView** with JavaScript enabled loading untrusted content (XSS/JS-bridge risks).\n- Not using `FLAG_IMMUTABLE` on PendingIntents.\n\nSpotting these in review is exactly what senior interviewers want to hear."
        ],
        [
            'question' => "Q101. What are the types of tests in Android and what does each cover?",
            'answer' => "- **Unit tests** — test a single class/function in isolation (e.g., a ViewModel or a use case), no Android framework, run fast on the JVM. The bulk of your tests.\n- **Integration tests** — test how pieces work together (e.g., Repository + Room DAO).\n- **UI / Instrumentation tests** — run on a device/emulator, test the actual UI (Espresso for Views, Compose test APIs for Compose).\n\n**The testing pyramid:** many fast unit tests at the bottom, fewer integration tests in the middle, a small number of slow end-to-end UI tests at the top. Over-relying on slow UI tests is a common mistake."
        ],
        [
            'question' => "Q102. How do you unit test a ViewModel that calls a repository?",
            'answer' => "You **inject a fake/mock repository** (this is why dependency inversion matters), feed it controlled data, then assert the ViewModel emits the expected states.\n\nSteps:\n\n1. Replace the real repository with a fake returning known data (or use Mockito/MockK).\n2. Because the ViewModel uses coroutines, use a **test dispatcher** (`StandardTestDispatcher`/`runTest`) so coroutines run deterministically.\n3. Call the ViewModel function and **assert** the resulting state sequence: Loading → Success(expectedData), or Loading → Error.\n\nFor Flow/StateFlow, use **Turbine** to assert emissions cleanly. This shows you can test asynchronous code properly."
        ],
        [
            'question' => "Q103. What is a fake vs a mock, and which do you prefer?",
            'answer' => "- **Mock** — an object whose behavior you script per test (\"when `getUser` is called, return this\"), usually via a library (Mockito/MockK). You often verify _that_ methods were called.\n- **Fake** — a lightweight working implementation of the interface (e.g., an in-memory repository backed by a `MutableList`).\n\n**Preference:** **Fakes** are often more robust and readable for repositories/data sources because they behave like the real thing and don't break when you refactor internal call patterns. Mocks are handy for verifying interactions or for awkward-to-fake dependencies. Good engineers use both judiciously — and that nuance impresses."
        ],
        [
            'question' => "Q104. How do you test code that depends on coroutines and Dispatchers?",
            'answer' => "The trick is **don't hardcode dispatchers** — **inject** them. Pass a dispatcher (or a `CoroutineDispatcher` provider) into the class instead of calling `Dispatchers.IO` directly. In tests, inject a **test dispatcher** so coroutines execute on a controllable, single-threaded scheduler.\n\nUse `runTest { }` (from kotlinx-coroutines-test), which gives you a `TestScope` with virtual time — you can advance time instantly to test delays without actually waiting. Replace `Dispatchers.Main` in tests with `Dispatchers.setMain(testDispatcher)`. This makes async tests fast and deterministic instead of flaky."
        ],
        [
            'question' => "Q105. What makes a test \"good\" vs a test that just exists for coverage?",
            'answer' => "A good test:\n\n- Tests **behavior**, not implementation details (so refactoring doesn't break it).\n- Is **deterministic** (no flakiness from timing, network, or random data).\n- Is **readable** — its name and body clearly state what's expected.\n- **Fails for the right reason** and actually catches real regressions.\n\n**Anti-patterns:** chasing a coverage percentage with trivial tests, testing getters/setters, over-mocking until the test just re-asserts the mock setup, and flaky UI tests everyone learns to ignore. Saying \"100% coverage isn't the goal; catching real bugs is\" shows maturity."
        ],
        [
            'question' => "Q106. Your app crashes with a NullPointerException coming from Kotlin. How is that even possible if Kotlin is null-safe?",
            'answer' => "Kotlin's null safety protects you **within Kotlin** by separating nullable (`String?`) from non-null (`String`) types. But NPEs can still happen via:\n\n- **Platform types from Java** — a Java method returns a `String` that Kotlin treats as `String!` (unknown nullability). If it's actually `null` and you assign it to a non-null Kotlin type, boom.\n- **The !! operator** — you explicitly tell the compiler \"trust me, not null,\" and if you're wrong, it throws.\n- Uninitialized `lateinit` properties accessed before initialization.\n- **JSON parsing** with a library (like Gson) that ignores Kotlin nullability and forces `null` into a non-null field.\n\n**Fixes:** avoid !!, handle Java interop boundaries carefully (annotate or null-check), use Kotlin-aware serializers, and prefer safe calls (?.) and the Elvis operator (?:)."
        ],
        [
            'question' => "Q107. Explain `val` vs `var` vs `const val`, and why immutability matters.",
            'answer' => "- **var** — mutable; its value can change.\n- **val** — read-only reference; you can't reassign it (but if it points to a mutable object, the object's contents can still change).\n- **const val** — a compile-time constant; must be a primitive/String known at compile time, and is inlined. Used for true constants like `const val MAX = 10`.\n\n**Why immutability matters:** immutable data is **safer in concurrent code** (no surprise changes from another thread), easier to reason about, and plays well with Compose (which relies on stable, unchanging state to skip recompositions). Default to `val`; use `var` only when you genuinely need to reassign."
        ],
        [
            'question' => "Q108. What are data classes and why are they perfect for UI state and API models?",
            'answer' => "A **data class** auto-generates `equals()`, `hashCode()`, `toString()`, `copy()`, and destructuring based on its properties:\n\n```kotlin\ndata class User(val id: String, val name: String)\n```\n\n**Why perfect for state/models:**\n\n- `copy()` lets you make a modified copy without mutating the original — ideal for immutable UI state (`state.copy(isLoading = false)`).\n- `equals()` by content means Compose and DiffUtil can correctly detect \"did this actually change?\" and skip work if not.\n- They map cleanly to **JSON** for API responses."
        ],
        [
            'question' => "Q109. Explain higher-order functions and lambdas with a real Android use.",
            'answer' => "A **higher-order function** takes a function as a parameter or returns one. A **lambda** is a function written inline.\n\n**Real use everywhere in Android:**\n\n- Click listeners: `button.setOnClickListener { doSomething() }`.\n- Compose: `Button(onClick = { ... })`.\n- Collection operations: `list.filter { it.isActive }.map { it.name }`.\n- Coroutines: `launch { ... }` takes a lambda.\n\nThey make code concise and expressive. Kotlin's `inline` keyword on higher-order functions removes the overhead of creating function objects, which is why standard library functions like `map`/`filter` are efficient."
        ],
        [
            'question' => "Q110. What are extension functions and when do they make code cleaner?",
            'answer' => "An **extension function** lets you add a function to an existing class without modifying it:\n\n```kotlin\nfun String.isValidEmail(): Boolean = contains(\"@\") && contains(\".\")\n\"a@b.com\".isValidEmail()\n```\n\n**When cleaner:** adding utility behavior to framework classes you can't edit (`Context`, `View`, `String`), e.g., `fun Context.toast(msg: String) = Toast.makeText(this, msg, LENGTH_SHORT).show()`. They read naturally and avoid clunky static `Utils` classes.\n\n**Caveat:** they're resolved **statically** (not polymorphic) and don't truly add members — so don't overuse them to hide complex logic; keep them small and intention-revealing."
        ],
        [
            'question' => "Q111. What is the difference between == and === in Kotlin?",
            'answer' => "- == checks **structural equality** — it calls `equals()`. Two different objects with the same content are == if `equals` says so (data classes compare by content).\n- === checks **referential equality** — whether two references point to the **exact same object** in memory.\n\n**Why it matters:** for data classes, == is what you usually want (\"same content\"). === is occasionally used in optimizations (e.g., \"is this literally the same instance I had before, so I can skip work?\"). Mixing them up causes subtle bugs, like comparing two equal-but-distinct objects with === and getting `false`."
        ],
        [
            'question' => "Q112. Explain `let`, `apply`, `run`, `also`, and `with` — the scope functions everyone confuses.",
            'answer' => "They all execute a block on an object; the difference is **what they pass** and **what they return**:\n\n- **let** — passes the object as `it`, returns the **lambda result**. Great for null-checks: `user?.let { showProfile(it) }`.\n- **apply** — passes the object as `this`, returns the **object**. Great for configuring: `Intent().apply { putExtra(\"id\", 1) }`.\n- **run** — passes as `this`, returns the **lambda result**. Good for \"configure and compute a result.\"\n- **also** — passes as `it`, returns the **object**. Good for side-effects like logging: `user.also { log(it) }`.\n- **with** — not an extension; takes the object as an argument, passes as `this`, returns the lambda result.\n\n**Memory trick:** `apply`/`also` return the object (for chaining/config); `let`/`run`/`with` return the result (for computing). `apply`/`run`/`with` use `this`; `let`/`also` use `it`."
        ],
        [
            'question' => "Q113. What actually makes a function a \"composable,\" and why can't you call one from a normal function?",
            'answer' => "The `@Composable` annotation isn't just a label — it changes how the Kotlin compiler treats the function. The Compose compiler plugin rewrites every composable to receive a hidden `Composer` parameter. That `Composer` is what records your UI into the **slot table** (Compose's internal memory of your UI tree) and tracks which parts read which state, so it knows what to re-run later.\n\nBecause of that hidden `Composer`, a composable can only be called from somewhere that has one — i.e., another composable. A regular function has no `Composer` to pass down, so the compiler rejects the call. This is the same reason `suspend` functions can only be called from coroutines: both rely on machinery the compiler threads through behind the scenes."
        ],
        [
            'question' => "Q114. Explain the three phases of a Compose frame: composition, layout, drawing. Why does knowing them help performance?",
            'answer' => "Every frame, Compose can run up to three phases:\n\n1. **Composition** — _what_ to show. Your composables run and emit a tree of UI nodes.\n2. **Layout** — _where_ to put it. Each node is measured and placed (similar to measure + layout in the old View system, but in one smarter pass).\n3. **Drawing** — _how_ it looks. Nodes paint themselves to the canvas.\n\nThe performance insight: **you don't always need all three phases to re-run.** If only a scroll offset or a color changes, you can often skip composition and re-run just layout or drawing. This is why \"deferring state reads\" matters — reading a frequently-changing value (like scroll position) inside a `Modifier.offset { }` lambda defers the read to the **layout** phase, so composition is skipped entirely. Knowing which phase your state read lands in is the core of advanced Compose performance."
        ],
        [
            'question' => "Q115. `mutableStateOf` — how does changing it actually cause the screen to update?",
            'answer' => "`mutableStateOf` returns a `MutableState` object that Compose's **snapshot system** watches. When a composable reads `state.value` during composition, Compose records \"this composable depends on this state.\" When you later write a new value, Compose marks every composable that read it as **invalid**, and schedules them for **recomposition** on the next frame.\n\nSo the update isn't magic and it isn't a manual `invalidate()` call — it's automatic dependency tracking. You change data; Compose already knows exactly which slices of UI read that data and re-runs only those. This is why you never call anything like `notifyDataSetChanged()` in Compose.\n\nThe common bug: declaring `var count = 0` instead of `var count by remember { mutableStateOf(0) }`. A plain variable isn't observed, so changing it does nothing visible, and it resets every recomposition anyway."
        ],
        [
            'question' => "Q116. The order of Modifiers changes the result. Why, and give an example.",
            'answer' => "Modifiers form a **chain**, applied top-to-bottom, and each one wraps the result of the ones before it. So `padding` then `background` is not the same as `background` then `padding`.\n\n```scss\n// Padding first → background paints inside the padding (smaller colored area)\nModifier.padding(16.dp).background(Color.Red)\n\n// Background first → whole area is colored, padding pushes content inward\nModifier.background(Color.Red).padding(16.dp)\n```\n\nSame idea with `clickable` and `padding`: put `padding` before `clickable` and the padded area isn't tappable; put it after and the whole padded region responds to taps. Modifier order is one of the most common \"gotcha\" questions because it reveals whether you understand Compose draws and measures as a wrapped chain, not a property bag."
        ],
        [
            'question' => "Q117. What is `LazyColumn`, how is it different from a `Column` inside a scroll, and why do `key`s matter?",
            'answer' => "A `Column` with `verticalScroll` **composes every child immediately**, even off-screen ones. For 10,000 items that's a disaster. `LazyColumn` only composes the items currently visible (plus a small buffer) and recycles as you scroll — it's the Compose equivalent of RecyclerView.\n\n**Why keys matter:** by default Compose identifies items by position. If you insert or reorder items, every item after the change looks \"new,\" so state (like an expanded card or a running animation) jumps to the wrong row. Giving each item a **stable, unique key** lets Compose track items by identity:\n\n```scss\nLazyColumn {\n    items(notes, key = { it.id }) { note -> NoteCard(note) }\n}\n```\n\nNow insertions animate correctly and item state stays attached to the right item."
        ],
        [
            'question' => "Q118. What does \"stability\" mean in Compose, and how does it decide whether a composable can be skipped?",
            'answer' => "When a composable recomposes, Compose tries to **skip** child composables whose inputs haven't changed. It can only do this safely if it can _trust_ that an input's equality is reliable — that's what **stable** means.\n\n- A type is **stable** if Compose can be sure that when its `equals()` says \"unchanged,\" nothing the UI cares about actually changed (and it notifies Compose when it does change). Primitives, `String`, and `@Immutable`/`@Stable` types qualify.\n- **Unstable** types — like a `List` (the interface could be a mutable list under the hood) or a class from a module the Compose compiler can't analyze — force Compose to assume they _might_ have changed, so it **can't skip** and recomposes unnecessarily.\n\n**Fixes:** use `kotlinx.collections.immutable` (`ImmutableList`) instead of `List`, mark your model classes `@Immutable` when appropriate, and keep state classes as simple immutable `data class`es. In 2026, **strong skipping mode** (now on by default with the modern Compose compiler) skips even composables with unstable parameters by comparing instances, which reduces this pain — but understanding _why_ stability exists is still prime interview material."
        ],
        [
            'question' => "Q119. What is recomposition scope, and why does reading state \"lower\" in the tree improve performance?",
            'answer' => "A **recomposition scope** is the smallest restartable region Compose can re-run on its own — roughly, the body of a composable function. When state changes, Compose restarts the **nearest enclosing scope** that read it, not the whole screen.\n\nSo if you read a fast-changing value at the top of a big screen composable, the _entire_ screen is a scope that must re-run. If instead you push that read down into a small leaf composable (or defer it into a lambda), only that tiny scope recomposes.\n\n**Practical rule:** keep state reads as close as possible to where they're used. A classic example is passing a value via a **lambda** (`{ counter }`) instead of the value itself, so the read happens inside the child's scope rather than the parent's. This single idea fixes a huge fraction of real Compose jank."
        ],
        [
            'question' => "Q120. Walk me through the side-effect APIs: `LaunchedEffect`, `DisposableEffect`, `SideEffect`, `rememberCoroutineScope`, `rememberUpdatedState`.",
            'answer' => "Composables must be **side-effect free** in their body because they can run many times and in any order. When you genuinely need a side effect, you use a controlled API:\n\n- **LaunchedEffect(key)** — runs a coroutine when it enters composition; cancels and restarts if `key` changes; cancels when it leaves. Use for: load-once data, observe a flow, show a snackbar when an error state appears.\n- **DisposableEffect(key)** — for effects that need **cleanup**. You register something (a sensor listener, a callback) and return an `onDispose { }` that unregisters it when the composable leaves or the key changes.\n- **SideEffect** — runs **after every successful recomposition**. Use it to publish Compose state to a non-Compose object (e.g., update an analytics property).\n- **rememberCoroutineScope()** — gives a scope tied to the composition that you launch from **event callbacks** (a button click), not from composition itself.\n- **rememberUpdatedState(value)** — captures the latest value inside a long-lived effect that you _don't_ want to restart. Classic case: a `LaunchedEffect(Unit)` with a timeout that should call the _current_ `onTimeout` lambda, not the one captured when the effect started.\n\nNaming the right tool for each scenario is exactly what's being tested here."
        ],
        [
            'question' => "Q121. What's the difference between `LaunchedEffect(Unit)` and `LaunchedEffect(someKey)`? Give a bug each one causes if misused.",
            'answer' => "The key controls **when the effect restarts**.\n\n- `LaunchedEffect(Unit)` (or `true`) runs **once** and never restarts. **Bug if misused:** you fetch data for a `userId`, but the user navigates to a different `userId` without the composable leaving composition — the effect never re-runs, so you show stale data for the wrong user.\n- `LaunchedEffect(userId)` restarts whenever `userId` changes — correct for the case above. **Bug if misused:** you accidentally key on something that changes every recomposition (like a freshly created object), so the effect **cancels and restarts constantly**, re-triggering network calls on every frame.\n\n**Rule:** the key should be exactly the set of inputs that, when changed, _should_ restart the work — no more, no less."
        ],
        [
            'question' => "Q122. How do you collect a ViewModel's `StateFlow` in Compose correctly, and what's wrong with plain `collectAsState()`?",
            'answer' => "Use `collectAsStateWithLifecycle()`:\n\n```kotlin\nval uiState by viewModel.uiState.collectAsStateWithLifecycle()\n```\n\nPlain `collectAsState()` keeps collecting even when the app is in the background (the composition is still alive but not visible), wasting work and sometimes processing updates for a screen the user can't see. `collectAsStateWithLifecycle()` ties collection to the lifecycle — it pauses collection below the `STARTED` state and resumes when the screen comes back. On Android it's the recommended default for any flow coming from outside the UI. Mentioning _why_ (background work, lifecycle awareness) is the senior-level part of this answer."
        ],
        [
            'question' => "Q123. What is `derivedStateOf` and how is it different from just computing a value in the composable?",
            'answer' => "`derivedStateOf` creates a state whose value is **computed from other state**, and — crucially — only triggers recomposition when the **computed result** changes, not every time the inputs change.\n\n**Classic example:** \"Show a 'scroll to top' button only after the user scrolls past item 5.\" The scroll position changes on every pixel of scrolling, but `showButton` only flips between true/false a couple of times.\n\n```kotlin\nval showButton by remember {\n    derivedStateOf { listState.firstVisibleItemIndex > 5 }\n}\n```\n\nWithout `derivedStateOf`, you'd read the raw scroll index and recompose on every scroll frame. With it, you recompose only when the boolean actually changes. Computing the value plainly in the composable body re-runs the calculation every recomposition; `derivedStateOf` caches and gates it."
        ],
        [
            'question' => "Q124. What is `snapshotFlow` and when would you use it?",
            'answer' => "`snapshotFlow` converts Compose **State** into a cold **Flow**, so you can use Flow operators (`debounce`, `filter`, `distinctUntilChanged`, `map`) on values that live in Compose's snapshot system.\n\n**Real use:** react to scroll. You want to log an analytics event or load more data when the user reaches a certain item, but you don't want to fire on every frame:\n\n```scss\nLaunchedEffect(listState) {\n    snapshotFlow { listState.firstVisibleItemIndex }\n        .distinctUntilChanged()\n        .collect { index -> /* react */ }\n}\n```\n\nIt bridges the Compose world (State) and the coroutines/Flow world cleanly, which is otherwise awkward."
        ],
        [
            'question' => "Q125. What is `remember(key)` with a key, and how is it different from plain `remember`?",
            'answer' => "Plain `remember { }` computes a value once and keeps it for the life of the composable, ignoring everything. `remember(key) { }` **recomputes** the value whenever the `key` changes.\n\n**Why it matters:** say you build a formatter or filter a list based on a `query`. With plain `remember`, you'd compute it once and never update when the query changes — a stale-data bug. With `remember(query) { expensiveFilter(query) }`, it recomputes exactly when `query` changes and caches the result otherwise. It's the middle ground between \"recompute every recomposition\" (no remember) and \"never recompute\" (plain remember)."
        ],
        [
            'question' => "Q126. What is `CompositionLocal`, and what problem does it solve? Give a real example.",
            'answer' => "`CompositionLocal` lets you pass data **implicitly down the tree** without threading it through every composable's parameters. Think of it as scoped, tree-wide ambient data.\n\n**Real examples you already use:** `MaterialTheme` (colors, typography, shapes), `LocalContext`, `LocalConfiguration`, `LocalDensity`. You read `MaterialTheme.colorScheme.primary` deep in the tree without anyone passing it down manually.\n\n**When to create your own:** truly cross-cutting concerns that _most_ of a subtree needs — like a theme, a logged-in user's preferences, or an image loader. **When NOT to:** ordinary data flow. Overusing CompositionLocal makes data sources implicit and hard to trace, which hurts testability. The interview-strong answer names both the use _and_ the abuse."
        ],
        [
            'question' => "Q127. How does navigation work in Compose, and how do you pass arguments and pop the back stack?",
            'answer' => "Compose Navigation uses a `NavController` and a `NavHost` that maps **routes** (strings, or type-safe routes in the newer API) to composable destinations:\n\n```scss\nNavHost(navController, startDestination = \"list\") {\n    composable(\"list\") { ListScreen(onItem = { id -> navController.navigate(\"detail/\$id\") }) }\n    composable(\"detail/{id}\") { backStackEntry ->\n        DetailScreen(id = backStackEntry.arguments?.getString(\"id\"))\n    }\n}\n```\n\nTo clear screens off the back stack — e.g., after login you don't want Back to return to the login screen — use `popUpTo` with `inclusive`:\n\n```javascript\nnavController.navigate(\"home\") {\n    popUpTo(\"login\") { inclusive = true }\n}\n```\n\nThe modern type-safe Navigation (using `@Serializable` route objects) removes the stringly-typed routes and argument-parsing boilerplate — worth mentioning to show you're current."
        ],
        [
            'question' => "Q128. Where should navigation state and events live in the composable or the ViewModel? Defend your choice.",
            'answer' => "Navigation _triggers_ (what the user did) belong in the **ViewModel as one-time events**; the _act_ of navigating belongs in the **UI layer** (it owns the `NavController`).\n\nThe anti-pattern is passing the `NavController` _into_ ViewModels — that couples your business logic to the navigation framework, leaks UI concerns into the ViewModel, and makes the ViewModel hard to test. Instead, the ViewModel emits an event (\"navigate to detail with id 42\") via a `SharedFlow`/`Channel`, and the composable collects it and calls `navController.navigate(...)`. This keeps the ViewModel pure and the navigation logic where it belongs. This separation is a frequent senior-round discussion."
        ],
        [
            'question' => "Q129. How do animations work in Compose? Walk through the common APIs.",
            'answer' => "Compose animations are **state-driven** — you animate _toward_ a target value and Compose handles the frames.\n\n- `animate*AsState` (`animateFloatAsState`, `animateColorAsState`, `animateDpAsState`) — the simplest: give a target value, get a smoothly animating value back. Great for animating a single property like a color or size on state change.\n- `AnimatedVisibility` — animates a composable entering/leaving (fade, slide, expand).\n- `updateTransition` — coordinates **multiple** animations driven by the same state change so they stay in sync.\n- `Animatable` — lower-level, gives precise control and is great for gesture-driven or interruptible animations; you drive it from a coroutine.\n- `AnimatedContent` — animates swapping between different composables based on state.\n\nThe mental model worth stating: you don't write frame loops; you change state, and the animation APIs interpolate for you."
        ],
        [
            'question' => "Q130. What are slot APIs / the \"content lambda\" pattern, and why is it better than lots of boolean parameters?",
            'answer' => "A **slot API** is a composable that accepts a `@Composable` lambda for part of its content, letting the caller decide what goes there:\n\n```less\n@Composable\nfun CardWithHeader(header: @Composable () -> Unit, content: @Composable () -> Unit) { ... }\n```\n\nThis is \"composition over configuration.\" Instead of a component with twenty boolean/string parameters (`showIcon`, `iconType`, `trailingText`, `trailingIsButton`…) that never quite fits every case, you expose **slots** the caller fills with arbitrary content. It's exactly how `Scaffold` (with `topBar`, `bottomBar`, `floatingActionButton` slots) and `Button` (with a `content` slot) are built. The result is flexible, reusable components that don't need editing every time a new variation appears."
        ],
        [
            'question' => "Q131. Why must composables be idempotent and free of side effects in their body? What breaks if they aren't?",
            'answer' => "Compose can call your composable **any number of times, in any order, on any thread, and skip it entirely** — composition is not guaranteed to run once or in the sequence you wrote. So the body must produce the same UI for the same inputs and must not cause observable side effects.\n\n**What breaks if you ignore this:**\n\n- Doing `viewModel.loadData()` directly in the body → it fires on **every recomposition**, hammering your API.\n- Incrementing a counter or adding to a list in the body → unpredictable values, since you don't control how many times it runs.\n- Launching a coroutine directly → multiple uncontrolled coroutines.\n\nThat's the entire reason the side-effect APIs (Q120) exist: to give side effects a defined, controlled lifecycle instead of riding on composition."
        ],
        [
            'question' => "Q132. How do you build a fully custom layout in Compose (something Row/Column/Box can't express)?",
            'answer' => "You use the `Layout` composable (or the `Modifier.layout { }` for single-element tweaks). `Layout` gives you the children as **measurables**; you measure each within constraints, decide the overall size, and place each child at an x/y:\n\n```javascript\nLayout(content = content) { measurables, constraints ->\n    val placeables = measurables.map { it.measure(constraints) }\n    layout(width, height) {\n        // place each placeable at computed x, y\n    }\n}\n```\n\nThis is the Compose equivalent of writing a custom `ViewGroup` with `onMeasure`/`onLayout`, but far less code. Use it for things like flow layouts (chips wrapping to the next line), custom grids, or radial arrangements. For _adaptive_ layouts that need to know available space before composing children, use `BoxWithConstraints` or `SubcomposeLayout`."
        ],
        [
            'question' => "Q133. What's the difference between `Modifier.composed { }`, a regular Modifier factory, and why did `composed` get a bad reputation?",
            'answer' => "A plain Modifier factory (`fun Modifier.myThing() = this.then(...)`) is stateless and cheap. `Modifier.composed { }` was the old way to create a Modifier that needs **composition-aware state** (like `remember` or reading a CompositionLocal inside a modifier).\n\nThe problem: `composed` defeats some of Compose's optimizations — modifiers built with it can't be compared/skipped as efficiently and can hurt performance when used widely. That's why the modern `Modifier.Node` API replaced it: it lets you write stateful, high-performance custom modifiers without the `composed` overhead. Knowing this history signals you've kept up with Compose's evolution, not just learned it once."
        ],
        [
            'question' => "Q134. How do you handle a one-time event (show a toast, navigate, show a snackbar) so it doesn't re-fire on rotation/recomposition?",
            'answer' => "This is the **\"event vs state\"** problem. If you model \"show snackbar\" as part of your `StateFlow` UI state, then on recomposition or config change the UI sees that state again and re-shows the snackbar — a classic duplicate-event bug.\n\n**Solutions:**\n\n- Expose events through a `Channel` (exposed as `receiveAsFlow()`) or a `SharedFlow` with no replay — these deliver each event **once** to the collector.\n- Collect them in a `LaunchedEffect` and act (navigate/show snackbar).\n- After handling state-based events, **reset** the flag (`state.copy(error = null)`) so it doesn't re-trigger.\n\nThe principle: **persistent state** is rendered every frame; **events** must be consumed exactly once. Mixing them up is one of the most common Compose bugs in production."
        ],
        [
            'question' => "Q135. Your Compose screen recomposes far more than expected. How do you diagnose and fix it?",
            'answer' => "**Diagnose:**\n\n- Use the **Layout Inspector's recomposition counts** in Android Studio — it shows how many times each composable recomposed and how many were skipped. High counts on stable-looking UI signal a problem.\n- Run the **Compose Compiler reports** (stability metrics) to see which composables are `skippable`/`restartable` and which parameters are `unstable`.\n\n**Common fixes:**\n\n- Unstable parameters (raw `List`, classes the compiler can't see) → use immutable collections, `@Immutable`, or move to a multi-module-aware setup.\n- Reading a fast-changing state too high → push the read down or defer it into a lambda/modifier (Q114, Q119).\n- Passing **new lambda instances** every recomposition → they're fine in most cases now with the modern compiler, but capturing unstable values in them can break skipping.\n- Expensive work in the body → wrap in `remember`/`derivedStateOf`.\n\nSaying \"measure with recomposition counts and compiler reports _before_ optimizing\" is the answer that lands."
        ],
        [
            'question' => "Q136. What changed with the Compose Compiler being merged into Kotlin, and what is \"strong skipping mode\"?",
            'answer' => "Historically the Compose compiler had its own version that you had to keep in lockstep with your Kotlin version — a constant source of build headaches. From Kotlin 2.0 onward, the **Compose Compiler moved into the Kotlin repository** and is shipped as a Kotlin Gradle plugin, so it versions _with_ Kotlin. That removes the compatibility-matrix pain.\n\n**Strong skipping mode** (now enabled by default in current Compose) lets Compose **skip composables even when they have unstable parameters**, by comparing instances for equality rather than refusing to skip outright. It also remembers lambdas automatically. In practice this means a lot of the manual stability tuning developers used to do is now handled for you — though understanding stability still matters for diagnosing the cases it can't save you from. Mentioning this shows you're current as of 2026, not quoting a 2021 tutorial."
        ],
        [
            'question' => "Q137. How do you test a Compose UI? What's the basic structure?",
            'answer' => "You use the **Compose test APIs** with a `createComposeRule()`:\n\n```less\n@get:Rule val composeRule = createComposeRule()\n\n@Test fun showsErrorMessage() {\n    composeRule.setContent { MyScreen(state = UiState.Error(\"No internet\")) }\n    composeRule.onNodeWithText(\"No internet\").assertIsDisplayed()\n    composeRule.onNodeWithTag(\"retry\").performClick()\n}\n```\n\nYou find nodes by **text**, **content description**, or **test tags** (`Modifier.testTag(\"retry\")`), then assert state or perform actions. Because well-built Compose screens are **stateless** and driven by a hoisted state parameter (Q31), you can test every UI state — loading, success, error, empty — just by passing different state in, with no ViewModel, network, or navigation needed. That testability is a direct payoff of state hoisting, and connecting the two is a strong closing point."
        ],
        [
            'question' => "Q138. A junior says \"Compose is slower than XML.\" How do you respond?",
            'answer' => "Calmly and with nuance. Out of the box, a _naively written_ Compose screen can recompose more than necessary, and Compose has a slightly higher cold-start cost on first composition. But:\n\n- For well-structured Compose (stable inputs, proper state scoping, lazy lists with keys), runtime performance is on par with or better than equivalent Views, and the code is far less error-prone.\n- **Baseline Profiles** dramatically reduce Compose's first-run cost by precompiling hot paths — a must-ship for production Compose apps.\n- Most \"Compose is slow\" complaints trace back to specific anti-patterns (unstable params, reading scroll state too high, no keys), all fixable.\n\nThe senior move is to **reframe**: it's rarely \"Compose vs XML,\" it's \"did we write it well and ship a baseline profile?\" Then point to _measuring_ with recomposition counts rather than arguing from vibes.\n\n### Final Tips: How to Actually Pass the Interview (Not Just Memorize)\n\nKnowing answers is only half the game. Here's how to _use_ this knowledge in the room:\n\n1. **Always explain the \"why,\" not just the \"what.\"** Anyone can say \"ViewModel survives rotation.\" Saying _why it was invented_ and _what bug it prevents_ is what separates senior from junior.\n2. **Think out loud.** When given a scenario, narrate your reasoning: \"First I'd check if it's main-thread work… then I'd profile… then I'd consider caching.\" Interviewers hire your **thought process**, not a memorized line.\n3. **Mention trade-offs.** \"I'd use MVI here, but it adds boilerplate, so for a simple screen MVVM is enough.\" Trade-off awareness is the #1 senior signal.\n4. **Admit limits honestly.** \"I haven't used X in production, but here's how I'd approach it.\" Honesty beats bluffing — interviewers can smell a bluff instantly.\n5. **Connect to real impact.** Tie answers back to **users** (faster app, no data loss, no crashes) and **the team** (testable, maintainable code). That shows you build products, not just code.\n6. **Practice the scenario format.** Re-read each question here as if a person is asking you across the table. Say the answer out loud. The gap between \"I know this\" and \"I can explain this clearly under pressure\" is closed only by speaking it.\n\n### Summary\n\nThis guide covered **138 real-world Android interview questions** — from the lifecycle basics every junior must know, through coroutines, architecture, performance, security, testing, Kotlin deep-dives, and a full Jetpack Compose section that today's senior interviews lean on heavily.\n\nBut don't treat it as a script to memorize. Treat it as a **map of how Android actually fits together**. Once you understand _why_ each piece exists and _what problem it solves_, you can answer questions you've never even seen — because you'll be reasoning from understanding, not recalling from memory.\n\nThat's the difference between someone who _passes_ an interview and someone who _deserves_ the role.\n\nNow close this tab, open Android Studio, and go build something. Then come back, read it again, and watch how much more it means once you've felt these problems yourself.\n\n**You've got this.**\n\n_If this guide helped you, save it, share it with a friend who's job-hunting, and bookmark it for the night before your interview. Good luck — go get that offer._\n\n**Credits:** [@anandgaur2207](https://medium.com/@anandgaur2207)\n\n**Article:** [Android Interview Questions & Answers](https://medium.com/@anandgaur2207/android-interview-questions-answers-real-scenario-based-with-in-depth-explanations-aaaac3195813)"
        ],
    ]
];

get_header();
?>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" id="highlight-theme">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

<style>
.blog-content {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #e0e0e0;
}
.blog-content h1, .blog-content h2, .blog-content h3, .blog-content h4 {
    color: #ffffff;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}
.blog-content h1 { font-size: 2.2rem; }
.blog-content h2 { font-size: 1.8rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem; }
.blog-content h3 { font-size: 1.5rem; }
.blog-content p {
    margin-bottom: 1.5rem;
}
.blog-content ul, .blog-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}
.blog-content li {
    margin-bottom: 0.5rem;
}
.blog-content pre {
    background-color: #1e1e1e;
    padding: 2.5rem 1rem 1rem 1rem;
    border-radius: 8px;
    overflow-x: auto;
    border: 1px solid rgba(128,128,128,0.2);
    margin-bottom: 1.5rem;
    position: relative;
}
.blog-content code {
    background-color: rgba(255,255,255,0.1);
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-family: monospace;
    font-size: 0.9em;
    color: var(--highlight-orange, #ff7b00);
}
.blog-content pre code {
    background-color: transparent;
    padding: 0;
    color: inherit;
}
.blog-content blockquote {
    border-left: 4px solid var(--color-orange, #ff7b00);
    padding-left: 1rem;
    margin-left: 0;
    font-style: italic;
    color: #a0a0a0;
}
.blog-content a {
    color: var(--color-orange, #ff7b00);
    text-decoration: underline;
}
.blog-content a:hover {
    color: var(--highlight-orange, #ff7b00);
}
.blog-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
}

/* Light mode overrides for blog content */
body.light-mode .blog-content { color: #333333; }
body.light-mode .blog-content h1, 
body.light-mode .blog-content h2, 
body.light-mode .blog-content h3, 
body.light-mode .blog-content h4 { color: #1a1a1a; }
body.light-mode .blog-content h2 { border-bottom: 1px solid rgba(0,0,0,0.1); }
body.light-mode .blog-content pre { 
    background-color: #eef2f5 !important;
    border: 1px solid rgba(0,0,0,0.15); 
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
}
body.light-mode .blog-content code { 
    background-color: rgba(0,0,0,0.06); 
    color: var(--color-orange, #ff7b00); 
}
body.light-mode .blog-content pre code,
body.light-mode .blog-content pre code.hljs { 
    background-color: transparent !important;
    color: #24292e; 
}
body.light-mode .blog-content blockquote { color: #666666; }


.code-wrapper {
    position: relative;
}
.copy-code-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: #e0e0e0;
    padding: 5px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    z-index: 5;
}
.copy-code-btn:hover {
    background: var(--color-orange);
    color: #fff;
    border-color: var(--color-orange);
}
body.light-mode .copy-code-btn {
    background: rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.1);
    color: #333;
}
body.light-mode .copy-code-btn:hover {
    background: var(--color-orange);
    color: #fff;
    border-color: var(--color-orange);
}


.blog-back-btn {
    display: inline-block;
    color: var(--color-orange);
    transition: all 0.3s ease;
}
.blog-back-btn:hover {
    background-color: var(--color-orange);
    color: #fff !important;
}
</style>

<main id="primary" class="site-main">
    <section class="section-padding dark-bg" style="padding-top: 150px; position: relative;">
        
        <!-- Back button -->
        <div style="position: absolute; top: 120px; left: 40px; z-index: 10;">
            <a href="<?php echo esc_url(home_url('/src/blog/blog_list_page.php')); ?>" class="btn-cert-small blog-back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Blogs</a>
        </div>

        <div class="container" style="max-width: 900px;">
            
            <article class="glass-card" style="padding: 40px; border: 1px solid rgba(128,128,128,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                
                <header style="margin-bottom: 40px; text-align: center;">
                    <h1 style="font-size: 2.5rem; line-height: 1.3; margin-bottom: 20px;">
                        <?php echo esc_html($blog_data['meta']['title'] ?? 'Untitled'); ?>
                    </h1>
                    
                    <?php if (!empty($blog_data['meta']['subtitle'])): ?>
                        <p style="font-size: 1.2rem; color: #a0a0a0; margin-bottom: 20px;">
                            <?php echo esc_html($blog_data['meta']['subtitle']); ?>
                        </p>
                    <?php endif; ?>
                    
                    <div style="color: var(--color-orange); font-size: 1rem; margin-bottom: 20px;">
                        <i class="fa-regular fa-calendar" style="margin-right: 8px;"></i>
                        <?php 
                            if (isset($blog_data['meta']['published'])) {
                                echo esc_html(date('F j, Y', strtotime($blog_data['meta']['published'])));
                            } else {
                                echo 'Unknown Date';
                            }
                        ?>
                    </div>
                    
                    <div class="project-tags justify-content-center">
                        <?php 
                        if (isset($blog_data['meta']['tags']) && is_array($blog_data['meta']['tags'])) {
                            foreach ($blog_data['meta']['tags'] as $tag) {
                                echo '<span>' . esc_html($tag) . '</span>';
                            }
                        }
                        ?>
                    </div>
                </header>
                
                <div class="section-line" style="margin-bottom: 40px;"></div>
                
                <div class="blog-content">
                    <?php 
                        if (!empty($blog_data['qna'])) {
                            echo '<div class="qna-container">';
                            $counter = 1;
                            foreach ($blog_data['qna'] as $qa) {
                                echo '<div class="qna-block" style="margin-bottom: 40px; padding-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.05);">';
                                
                                echo '<h2 class="qna-question" style="font-size: 1.6rem; color: var(--highlight-orange); margin-bottom: 20px; display: flex; align-items: flex-start; gap: 15px;">';
                                echo '<span style="flex-grow: 1; padding-top: 4px;">' . esc_html($qa['question']) . '</span>';
                                echo '</h2>';
                                
                                echo '<div class="qna-answer" style="padding-left: 15px; border-left: 2px solid rgba(128,128,128,0.2); margin-left: 20px;" data-md="' . base64_encode($qa['answer']) . '">';
                                echo '</div>';
                                
                                echo '</div>';
                                $counter++;
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="blog-fallback-body" data-md="' . base64_encode($blog_data['body']) . '"></div>';
                        }
                    ?>
                </div>
                
            </article>
            
        </div>
    </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    function processMarkdownBlocks(selector) {
        document.querySelectorAll(selector).forEach(function(el) {
            if(el.dataset.md) {
                var rawMd = decodeURIComponent(escape(window.atob(el.dataset.md)));
                el.innerHTML = marked.parse(rawMd);
                el.classList.add('blog-content');
                
                el.querySelectorAll('pre').forEach(function(preBlock) {
                    var wrapper = document.createElement('div');
                    wrapper.className = 'code-wrapper';
                    preBlock.parentNode.insertBefore(wrapper, preBlock);
                    wrapper.appendChild(preBlock);
                    
                    var codeEl = preBlock.querySelector('code');
                    if (codeEl) {
                        hljs.highlightElement(codeEl);
                    }
                    
                    var btn = document.createElement('button');
                    btn.className = 'copy-code-btn';
                    btn.innerHTML = '<i class="fa-regular fa-copy"></i> Copy';
                    
                    btn.addEventListener('click', function() {
                        var code = codeEl ? codeEl.innerText : preBlock.innerText;
                        navigator.clipboard.writeText(code).then(function() {
                            btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
                            setTimeout(function() { 
                                btn.innerHTML = '<i class="fa-regular fa-copy"></i> Copy'; 
                            }, 2000);
                        });
                    });
                    
                    wrapper.appendChild(btn);
                });
            }
        });
    }

    
    processMarkdownBlocks('.qna-answer');
    processMarkdownBlocks('.blog-fallback-body');
    
    
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === "class") {
                var isLight = document.body.classList.contains('light-mode');
                var themeLink = document.getElementById('highlight-theme');
                if (isLight) {
                    themeLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css';
                } else {
                    themeLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css';
                }
            }
        });
    });
    observer.observe(document.body, { attributes: true });
    
    if (document.body.classList.contains('light-mode')) {
        document.getElementById('highlight-theme').href = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css';
    }
});
</script>

<?php get_footer(); ?>
