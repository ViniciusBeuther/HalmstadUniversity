package Assignment_01.Question_09;

import java.util.ArrayList;
import java.util.List;

public class Stack {
    private Message bottom;
    private Message top;
    private List<Message> elements;

//  Constructor, it receives a list of integers as param
    public Stack( List<Message> messages ){
        this.setElements(messages);
        this.setTop( this.getElements().get(this.getElements().size()-1) );
        this.setBottom( this.getElements().get(0) );
    }

    public Message getBottom() {
        return bottom;
    }

    public void setBottom(Message bottom) {
        this.bottom = bottom;
    }

    public Message getTop() {
        return top;
    }

    public void setTop(Message top) {
        this.top = top;
    }

    public List<Message> getElements() {
        return elements;
    }

    public void setElements(List<Message> elements) {
        this.elements = elements;
    }

//  add elements to the stack (@params: number of elements to be inserted, array of new elements)
    public void push( int nElements, List<Message> newElementsArray ){
        ArrayList<Message> updatedStack = new ArrayList<>(this.getElements());

        for( int i=0; i<nElements; i++ ){
            updatedStack.add(newElementsArray.get(i));
            this.setElements(updatedStack);
            this.setTop(updatedStack.get(updatedStack.size() - 1));
        }
    }

//  Pop n values
    public ArrayList<Message> pop( int n ){
        List<Message> updatedList = this.getElements();
        ArrayList<Message> removedElements = new ArrayList<>();

        if( n > this.getElements().size() ){
            throw new IndexOutOfBoundsException("Tried to remove more elements than the list has.");
        }

        for( int i=0; i<n; i++ ){
            removedElements.add(updatedList.remove(this.getElements().size() - 1));
        }
//        System.out.println("elements removed: " + removedElements);

        this.setElements( updatedList );
        this.setTop( updatedList.get(updatedList.size() - 1) );

        return removedElements;
    }

//  Returns how many messages there are in the stack
    public Integer size(){
        return this.getElements().size();
    }
}
