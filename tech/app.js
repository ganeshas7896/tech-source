const $=s=>document.querySelector(s),root=document.documentElement;
$('#theme').onclick=()=>{const t=root.dataset.theme=='dark'?'light':'dark';root.dataset.theme=t;try{localStorage.setItem('theme',t)}catch(e){}};
$('#menu').onclick=()=>$('#links').classList.toggle('open');
const box=$('#chatBox'),msgs=$('#msgs');
const history=[];
let busy=false;
const encoder=new TextEncoder();
const trimHistory=()=>{while(history.length>10||history.length>1&&history.reduce((size,message)=>size+encoder.encode(message.content).length,0)>11000)history.shift()};
const add=(t,c)=>{const d=document.createElement('div');d.className='m '+c;d.textContent=t;msgs.append(d);msgs.scrollTop=msgs.scrollHeight;return d};
const welcome=()=>add('Hi! I can help with programming, web development, frameworks, databases, cloud, AI, testing, and step-by-step learning plans. What would you like to learn?','b');
$('#chatBtn').onclick=()=>{box.hidden=!box.hidden;if(!msgs.children.length)welcome()};
$('#newChat').onclick=()=>{history.length=0;msgs.replaceChildren();welcome();$('#q').focus()};
async function send(){const q=$('#q').value.trim();if(!q||busy)return;$('#q').value='';add(q,'u');history.push({role:'user',content:q});trimHistory();
 busy=true;$('#send').disabled=true;const typing=add('Thinking…','b');
 try{const r=await fetch('chat.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({messages:history})});const data=await r.json().catch(()=>({error:'The AI service returned an invalid response. Please try again.'}));typing.remove();
  if(!r.ok)throw new Error(data.error||'The AI service could not answer right now. Please try again.');
  if(typeof data.a!=='string')throw new Error('The AI service returned an invalid answer. Please try again.');
  history.push({role:'assistant',content:data.a});trimHistory();add(data.a,'b');
 }catch(e){typing.remove();history.pop();add(e.message||'The AI assistant could not be reached. Please try again.','b')}
 finally{busy=false;$('#send').disabled=false;$('#q').focus()}}
$('#send').onclick=send;$('#q').onkeydown=e=>{if(e.key=='Enter')send()};
