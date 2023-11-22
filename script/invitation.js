document.querySelector('.recues').addEventListener('click',()=>{
    document.querySelector('.gamesReceive').classList.remove('cacher')
    document.querySelector('.gamesSend').classList.add('cacher')
    document.querySelector('.games').classList.add('cacher')
})


document.querySelector('.envoyees').addEventListener('click',()=>{
    document.querySelector('.gamesReceive').classList.add('cacher')
    document.querySelector('.gamesSend').classList.remove('cacher')
    document.querySelector('.games').classList.add('cacher')
})

document.querySelector('.encours').addEventListener('click',()=>{
    document.querySelector('.gamesReceive').classList.add('cacher')
    document.querySelector('.gamesSend').classList.add('cacher')
    document.querySelector('.games').classList.remove('cacher')
})